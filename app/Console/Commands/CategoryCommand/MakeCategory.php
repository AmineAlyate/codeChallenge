<?php

namespace App\Console\Commands\CategoryCommand;

use App\Services\CategoryService\CategoryService;
use Illuminate\Console\Command;

class MakeCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Category';


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
        $name = $this->ask('The Category name ');
        $parentCategoryId = $this->ask('The parent categorie id ');

        $data = ["name" => $name, 'parentCategorieId' => $parentCategoryId];
        $created = $this->categoryService->create($data);

        $this->info($name . ' has been add successfully with the id ' . $created->id);
    }
}
