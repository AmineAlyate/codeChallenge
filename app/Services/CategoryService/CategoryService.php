<?php

namespace App\Services\CategoryService;

use App\Repositories\CategoryRepository\CategoryRepository;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function create(array $data): object
    {
        try {
            $createdCategory = $this->categoryRepository->create($data);
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['errors' => $exception]);
        }

        return $createdCategory;
    }

    public function exists(int $id): bool
    {
        $exists = $this->categoryRepository->exists($id);

        return $exists;
    }

    public function delete(int $id)
    {
        $this->categoryRepository->delete($id);
    }
}
