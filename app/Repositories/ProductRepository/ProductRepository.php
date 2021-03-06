<?php

namespace App\Repositories\ProductRepository;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function all(): collection
    {
        $products = Product::all();

        return $products;
    }

    public function create(array $data): object
    {
        $createdProduct = Product::create($data['product']);
        $createdProduct->categories()->attach($data['categories']);

        return $createdProduct;
    }

    public function find(int $id): bool
    {
        $exist = Product::find($id)->exists();

        return $exist;
    }

    public function delete(int $id)
    {
        Product::find($id)->delete();
    }

    public function filterByCategory(int $id): Collection
    {
        $filtredProducts = Product::whereHas('categories', function ($q) use ($id) {
            $q->where('categories.id', '=', $id);
        })->get();

        return $filtredProducts;
    }
}
