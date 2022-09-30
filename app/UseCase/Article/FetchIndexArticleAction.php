<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FetchIndexArticleAction
{
    public function __invoke(): Collection
    {
        try {
            $articles = Cache::tags(['article', 'index'])
                ->rememberForever('FetchIndexArticleAction', function () {
                    return Article::select('id', 'title', 'permalink', 'publish_at', 'image_id', 'category_id')->get()
                    ->whereNotNull('publish_at')
                    ->sortByDesc('publish_at');
                });
               $articles->load(['image', 'category']);
            return $articles;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
