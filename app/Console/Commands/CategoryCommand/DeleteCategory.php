<?php

namespace App\Console\Commands\CategoryCommand;

use App\Services\CategoryService\CategoryService;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:category {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Category';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();

        $this->categoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $existed = $this->categoryService->find($id);
        if ($existed) {
            $this->categoryService->delete($id);
            $this->info("Category Deleted successfully");
        } else {
            $this->info("There is no category with the gived id!!");
        }
    }
}
