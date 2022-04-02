<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed product_id
 * @property mixed quantity
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class Basket extends Model
{
    use HasFactory, SoftDeletes;


    public function product()
    {
        return $this->belongsTo(Products::class);
    }


}
