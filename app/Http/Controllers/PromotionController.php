<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionQuoteRequest;
use App\Models\Package;
use App\Services\PromotionService;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller
{
    public function __invoke(PromotionQuoteRequest $request, PromotionService $promotions): JsonResponse
    {
        $packages = Package::where('is_visible', true)->orderBy('sort_order')->get();

        return response()->json($promotions->catalog($packages, $request))
            ->header('Cache-Control', 'private, no-store');
    }
}
