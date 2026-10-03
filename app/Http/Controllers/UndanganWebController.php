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

class UndanganWebController extends Controller
{
    public function __invoke(Request $request, PromotionService $promotions): mixed
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

        $totalThemes = Theme::query()
            ->where('is_active', true)
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($category, fn ($q) => $q->where('theme_category_id', $category))
            ->count();

        $themes = Theme::query()
            ->select(['id', 'theme_category_id', 'name', 'view_path', 'thumbnail_portrait', 'is_premium', 'created_at'])
            ->with('themeCategory:id,name')
            ->where('is_active', true)
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($category, fn ($query) => $query->where('theme_category_id', $category))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->cursorPaginate(12);

        if ($request->ajax()) {
            $view = view()->first([
                'components.theme-catalog-items',
                'themes._item_list',
                'themes.partials.catalog-items',
            ], ['themes' => $themes, 'variant' => 'showcase']);

            return response()->json([
                'html' => $view->render(),
                'next_cursor' => $themes->nextCursor()?->encode(),
                'has_more' => $themes->hasMorePages(),
            ]);
        }

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
