<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class FetchAllArticleAction
{
    public function __invoke(User $user): LengthAwarePaginator
    {
        $articles = Article::select('id', 'title', 'permalink', 'publish_at')
        ->where('user_id', $user->id)
        ->paginate(15);
        return $articles;
    }
}
