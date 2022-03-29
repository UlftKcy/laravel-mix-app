<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed name
 * @property mixed description
 * @property mixed price
 * @property mixed quantity_in_stock
 * @property mixed sub_two_category_id
 */

class Products extends Model
{
    use HasFactory, SoftDeletes;

    public function subTwoCategory()
    {
        return $this->belongsTo(SubTwoCategory::class);
    }
}
