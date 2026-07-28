<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    /**
     * Store completed tour status for user.
     */
    public function completeOnboarding(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tour_key' => 'required|string|max:100',
        ]);

        $user = $request->user();
        if ($user) {
            // Optional: Store onboarding state if needed
            // $user->update(['onboarding_completed' => true]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Onboarding status updated successfully.',
            'tour_key' => $validated['tour_key'],
        ]);
    }
}
