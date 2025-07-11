<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LostItem extends Model
{
    protected $fillable = [
        'user_id',
        'lost_item_name',
        'place',
        'finder_name',
        'description',
        'photo1',
        'photo2',
        'photo3',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
