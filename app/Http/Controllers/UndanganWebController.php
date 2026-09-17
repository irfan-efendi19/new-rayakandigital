<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PreviewData;
use App\Models\Theme;
use App\Models\ThemeCategory;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UndanganWebController extends Controller
{
    public function __invoke(Request $request, PromotionService $promotions): View
    {
        $search = is_string($request->query('search'))
            ? mb_substr(trim($request->query('search')), 0, 100)
            : '';
        $category = filter_var($request->query('category'), FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]) ?: null;

        $categories = ThemeCategory::query()
            ->select(['id', 'name'])
            ->withCount(['themes' => fn ($query) => $query->where('is_active', true)])
            ->whereHas('themes', fn ($query) => $query->where('is_active', true))
            ->orderBy('name')
            ->get();

        $totalThemes = Theme::where('is_active', true)->count();
        $themes = Theme::query()
            ->select(['id', 'theme_category_id', 'name', 'view_path', 'thumbnail_portrait', 'is_premium'])
            ->with('themeCategory:id,name')
            ->where('is_active', true)
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($category, fn ($query) => $query->where('theme_category_id', $category))
            ->orderBy('name')
            ->orderBy('id')
            ->paginate(8)
            ->appends(array_filter(['search' => $search, 'category' => $category], fn ($value) => $value !== '' && $value !== null))
            ->fragment('tema');

        $packages = Package::with('features')
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $promotionCatalog = $promotions->catalog($packages, $request);

        $galleryPhotos = collect(PreviewData::query()->find(1, ['id', 'gallery_photos'])?->gallery_photos ?? [])
            ->filter(fn ($photo) => is_string($photo) && filled($photo))
            ->take(3)
            ->map(fn (string $photo) => Str::startsWith($photo, ['https://', 'http://'])
                ? $photo
                : Storage::disk('public')->url($photo))
            ->values();

        return view('undangan-web', compact(
            'categories', 'themes', 'totalThemes', 'search', 'category', 'packages', 'promotionCatalog', 'galleryPhotos',
        ));
    }
}
