<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;

class FetchAllArticleAction
{
    public function __invoke(User $user): LengthAwarePaginator
    {
        try {
            $articles = Article::select('id', 'title', 'permalink', 'publish_at')
            ->where('user_id', $user->id)
            ->paginate(15);
            return $articles;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
