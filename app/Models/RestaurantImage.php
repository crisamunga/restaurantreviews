<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'restaurant_id'];

    public function getImageAttribute() {
        $image = $this->attributes['image'];
        if (isset($image)) {
            return asset($image);
        }
        return $image;
    }

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }
}
