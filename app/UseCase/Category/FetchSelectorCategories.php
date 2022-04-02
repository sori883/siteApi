<?php

namespace App\UseCase\Category;

use App\Models\Category;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FetchSelectorCategories
{
    public function __invoke(): Collection
    {
        try {
            $categories = Cache::tags(['category', 'selector'])->rememberForever('CategorySelector', function () {
                return Category::select('id', 'name')->get();
            });
            return $categories;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
