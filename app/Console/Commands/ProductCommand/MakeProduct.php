<?php

namespace App\Console\Commands\ProductCommand;

use App\Services\ProductService\ProductService;
use Illuminate\Console\Command;

class MakeProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('The product name ');
        $description = $this->ask('Description ');
        $price = $this->ask('price ');
        $image = $this->ask('the product image path ');
        $categories = $this->ask('the categories separated by comma ex: 1,2,3 ');
        
        //resolve image 
        $image = $this->productService->getUrlContent($image);
        $product = ['name' => $name, 'description' => $description, 'price' => $price, 'image' => $image];
        
        if ($categories != null) { //convert categories to array
            $categories = explode(',', $categories);
        }
        
        $data = ['product' => $product, "categories" => $categories];
        $created = $this->productService->create($data);
        $this->info($name . ' has been add successfully with id ' . $created['id']);
    }
}
