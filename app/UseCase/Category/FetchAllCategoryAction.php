<?php

namespace App\UseCase\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;

class FetchAllCategoryAction
{
    public function __invoke(): LengthAwarePaginator
    {
        try {
            $categories = Category::select('id', 'name', 'slug')
            ->paginate(50);
            return $categories;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
