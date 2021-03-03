<?php

namespace App\Console\Commands\ProductCommand;

use App\Services\ProductService\ProductService;
use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Product';

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
        $id = $this->argument('id');
        $existed = $this->productService->find($id);
        if ($existed) {
            $this->productService->delete($id);
            $this->info("Product Deleted successfully");
        } else {
            $this->info("There is no product with the gived id!!");
        }
    }
}
