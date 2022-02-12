<?php

namespace App\UseCase\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class FetchAllCategoryAction
{
    public function __invoke(): Collection
    {
        $categories = Category::select('id', 'name', 'slug')->get();
        return $categories;
    }
}
