<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubOneCategory extends Model
{
    use HasFactory,SoftDeletes;

    public function subTwoCategory(){
        return $this->hasMany(SubTwoCategory::class);
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }
}
