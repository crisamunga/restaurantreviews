<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon|mixed replied_on
 * @property string comment
 * @property Restaurant restaurant
 * @property User user
 * @property string reply
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'comment', 'visited_on', 'restaurant_id', 'user_id'];


    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
