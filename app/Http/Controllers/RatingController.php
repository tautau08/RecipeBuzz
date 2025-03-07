<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rating;

class RatingController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer',
            'recipe_id' => 'required|integer',
        ]);

        $existing = Rating::where('recipe_id', $request->recipe_id)->where('user_id', auth()->user()->id)->first();

        if ($existing) {
            $existing->rating = $request->rating;
            $existing->save();

            return response()->json([
                'message' => 'Successfully updated rating!',
                'rating' => $existing
            ], 200);
        }

        $rating = new Rating();
        $rating->rating = $request->rating;
        $rating->recipe_id = $request->recipe_id;
        $rating->user_id = auth()->user()->id;
        $rating->save();

        return response()->json([
            'message' => 'Successfully created rating!',
            'rating' => $rating
        ], 201);
    }
}
