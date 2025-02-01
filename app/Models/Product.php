<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [
        'id'
    ];

    public function properties()
    {
        return $this->hasMany(ProductProperty::class, 'product_id');
    }
}
