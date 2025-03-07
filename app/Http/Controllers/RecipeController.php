<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Recipe;

class RecipeController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->content = $request->content;
        $recipe->category = $request->category;
        $recipe->user_id = auth()->user()->id;
        $recipe->save();

        return response()->json([
            'message' => 'Successfully created recipe!',
            'recipe' => $recipe
        ], 201);
    }


    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json([
                'message' => 'Recipe not found!'
            ], 404);
        }

        if ($recipe->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized!'
            ], 401);
        }

        $recipe->title = $request->title;
        $recipe->content = $request->content;
        $recipe->category = $request->category;
        $recipe->save();

        return response()->json([
            'message' => 'Successfully updated recipe!',
            'recipe' => $recipe
        ], 200);
    }


    public function delete($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json([
                'message' => 'Recipe not found!'
            ], 404);
        }

        if ($recipe->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized!'
            ], 401);
        }

        $recipe->delete();

        return response()->json([
            'message' => 'Successfully deleted recipe!'
        ], 200);
    }


    public function getAll()
    {
        $recipes = Recipe::with('user:id,name')
                         ->withCount(['ratings', 'comments'])
                         ->withAvg('ratings', 'rating')
                         ->get(['id', 'title', 'category', 'user_id']);

        return response()->json([
            'recipes' => $recipes
        ], 200);
    }


    public function getSingleRecipe($id)
    {
        $recipe = Recipe::with(['user:id,name', 'comments.user:id,name'])
                        ->withCount(['ratings', 'comments'])
                        ->withAvg('ratings', 'rating')
                        ->where('id', $id)
                        ->first();

        if (!$recipe) {
            return response()->json([
                'message' => 'Recipe not found!'
            ], 404);
        }

        return response()->json([
            'recipe' => $recipe
        ], 200);
    }
}
