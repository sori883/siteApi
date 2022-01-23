<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FetchAllArticleAction
{
    public function __invoke(User $user): Collection
    {
        $articles = Article::select('id', 'title', 'permalink', 'publish_at')
        ->where('user_id', $user->id)
        ->get();
        return $articles;
    }
}
