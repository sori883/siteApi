<?php

namespace App\UseCase\Category;

use App\Models\Category;

class DeleteAction
{
    public function __invoke(Category $category)
    {
        $category->delete();
    }
}
