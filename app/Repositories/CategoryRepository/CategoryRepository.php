<?php

namespace App\Repositories\CategoryRepository;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function all(): Collection
    {
        $categories = Category::all();

        return $categories;
    }

    public function create(array $data): object
    {
        $createdCategory = Category::create($data);

        return $createdCategory;
    }

    public function exists(int $id): bool
    {
        $exists = Category::where('id', $id)->exists();

        return $exists;
    }

    public function delete(int $id)
    {
        Category::find($id)->delete();
    }
}
