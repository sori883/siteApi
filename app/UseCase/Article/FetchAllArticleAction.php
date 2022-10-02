<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\Cache;

class FetchAllArticleAction
{
    public function __invoke(User $user, int $currentPage): LengthAwarePaginator
    {
        try {
            $articles = Cache::tags(['article', 'all'])
                ->rememberForever('FetchAllArticleAction-' . $currentPage, function () use ($user) {
                    return Article::select('articles.id', 'title', 'permalink', 'publish_at', 'slug')
                    ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
                    ->where('articles.user_id', $user->id)
                    ->paginate(15);
                });
            return $articles;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
