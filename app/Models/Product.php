<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = array("name", "description", "price", "image");

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'productId', 'categorieId');
    }
}
