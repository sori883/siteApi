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
            $articles = Cache::tags(['article', 'all'])->rememberForever('FetchAllArticleAction-' . $currentPage,function() use ($user) {
                return Article::select('id', 'title', 'permalink', 'publish_at')
                ->where('user_id', $user->id)
                ->paginate(15);
            });
            return $articles;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
