<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed name
 * @property mixed path
 * @property mixed size
 * @property mixed ext
 * @property mixed product_id
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class ProductImage extends Model
{
    use HasFactory, SoftDeletes;

    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}
