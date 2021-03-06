<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed name
 */
class MainCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function subOneCategory()
    {
        return $this->hasMany(SubOneCategory::class);
    }
}
