<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTwoCategory extends Model
{
    use HasFactory,SoftDeletes;

   /* public function subTwoCategory(){
        return $this->hasMany(Items::class);
    }*/

    public function subOneCategory()
    {
        return $this->belongsTo(SubOneCategory::class);
    }
}
