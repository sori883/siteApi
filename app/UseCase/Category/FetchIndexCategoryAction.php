<?php

namespace App\UseCase\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\Cache;

class FetchIndexCategoryAction
{
    public function __invoke(): Collection
    {
        try {
            $categories = Cache::tags(['category', 'index'])
                ->rememberForever('FetchIndexCategoryAction', function () {
                    return Category::select('id', 'name', 'slug')->get()
                        ->sortByDesc('name');
                });
            return $categories;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
