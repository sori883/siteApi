<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\Category;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FetchCategoryArticleAction
{
    public function __invoke(Category $category): Collection
    {
        try {
            $articles = Cache::tags(['article', 'categoryIndex'])
                ->rememberForever('FetchCategoryArticleAction-' . $category->name, function () use ($category) {
                    return Article::select('id', 'title', 'permalink', 'publish_at', 'image_id', 'category_id')
                    ->where('category_id', $category->id)->get();
                });
               $articles->load(['image', 'category']);
            return $articles;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
