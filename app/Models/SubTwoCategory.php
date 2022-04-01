<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed name
 * @property mixed sub_one_category_id
 */

class SubTwoCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function subOneCategory()
    {
        return $this->belongsTo(SubOneCategory::class);
    }
}
