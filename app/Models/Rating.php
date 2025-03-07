<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;


    protected $fillable = [
        'recipe_id',
        'user_id',
        'rating',
    ];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Summary of recipe
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }


    /**
     * Summary of avgRating
     * @param int $recipe_id
     */
    public function avgRating($recipe_id)
    {
        return Rating::where('recipe_id', $recipe_id)->avg('rating');
    }
}
