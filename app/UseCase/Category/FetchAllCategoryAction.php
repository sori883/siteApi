<?php

namespace App\UseCase\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class FetchAllCategoryAction
{
    public function __invoke(): LengthAwarePaginator
    {
        $categories = Category::select('id', 'name', 'slug')
        ->paginate(50);
        return $categories;
    }
}
