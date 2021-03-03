<?php

namespace App\Services\ProductService;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProductRepository\ProductRepository;
use Illuminate\Validation\ValidationException;

class ProductService
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all(): Collection
    {
        return $this->productRepository->all();
    }

    public function create(array $data): object
    {
        $createdProduct = [];

        $isValide = Validator::make($data["product"], [
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        try {
            $data["product"]["image"] = $this->uploadImage($data["product"]["image"]);
            $createdProduct = $this->productRepository->create($data);
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['errors' => $exception]);
        }


        return $createdProduct;
    }

    public function delete(int $id)
    {
        $this->productRepository->delete($id);
    }

    public function find(int $id): bool
    {
        return $this->productRepository->find($id);
    }

    public function filterByCategory(int $id): Collection
    {
        return $this->productRepository->filterByCategory($id);
    }

    protected function uploadImage(array $data): string
    {
        $imagePath = "";

        if (!empty($data["name"])) {
            file_put_contents(public_path('images/') . $data['name'], $data['content']);
            $imagePath = $data['name'];
        } else {
            $imagePath = "noIamge.png";
        }

        return $imagePath;
    }

    public function decodeBase64(?string $image): array
    {
        $data = [];

        if (!empty($image)) {
            $encoded = explode(";base64,", $image);
            $content = base64_decode($encoded[1]);
            $name = time() . '.' . substr($image, 11, strpos($image, ';') - 11);
            $data = ["content" => $content, "name" => $name];
        }

        return $data;
    }

    public function getUrlContent(?string $url): array
    {
        $data = [];

        if (!empty($image)) {
            $content = file_get_contents($url);
            $name = time() . '.' . substr($url, strrpos($url, '.') + 1);
            $data = ["content" => $content, "name" => $name];
        }

        return $data;
    }
}
