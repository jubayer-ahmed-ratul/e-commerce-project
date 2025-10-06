<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_at_price',
        'cost_per_item',
        'sku',
        'barcode',
        'quantity',
        'security_stock',
        'shiping',
        'visibility',
        'brand',
        'catagories',
    ];

    public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}
}
