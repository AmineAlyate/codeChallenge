<?php

namespace App\Http\Controllers;

use App\Services\ProductService\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return view("welcome");
    }

    public function all()
    {
        $products = $this->productService->all();

        return response()->json($products, 201);
    }

    public function create(Request $req)
    {
        $data = $req->all();
        $data["product"]["image"] = $this->productService->decodeBase64($data["product"]["image"]);
        $createdProduct = $this->productService->create($data);

        return response()->json($createdProduct, 201);
    }

    public function filterByCategory($id)
    {
        $filtred = $this->productService->filterByCategory($id);

        return response()->json($filtred, 201);
    }
}
