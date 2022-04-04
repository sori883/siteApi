<?php

namespace App\UseCase\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\Cache;

class FetchAllCategoryAction
{
    public function __invoke(int $currentPage): LengthAwarePaginator
    {
        try {
            $categories = Cache::tags(['category', 'all'])->rememberForever('categoryAll-' . $currentPage, function () {
                return Category::select('id', 'name', 'slug')
                ->paginate(15);
            });
            return $categories;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
