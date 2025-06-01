<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Services\Category\UpdateAction;
use Illuminate\Console\Command;

class EditCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:edit-category {id} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit category command';

    /**
     * Execute the console command.
     */
    public function handle(UpdateAction $action)
    {
        $id = $this->argument('id');
        $name = $this->argument('name');
        $this->output->text($id);
        $this->output->text($name);

        $category = Category::findOrFail($id);
        $action->update($category, ['name' => $name]);

        return self::SUCCESS;
    }
}
