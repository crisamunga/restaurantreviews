<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property string name
 * @property string image
 * @property integer user_id
 */
class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'user_id'];

    public function getImageAttribute() {
        $image = $this->attributes['image'];
        if (isset($image)) {
            return url(Storage::url($image));
        }
        return $image;
    }

    public function images() {
        return $this->hasMany(RestaurantImage::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
