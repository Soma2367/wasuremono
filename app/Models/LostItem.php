<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LostItem extends Model
{
    protected $fillable = [
        'lost_item_name',
        'place',
        'finder_name',
    ];
}
