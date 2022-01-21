<?php

namespace App\UseCase\Article;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class FetchAllArticleAction
{
    public function __invoke(): Collection
    {
        $articles = Article::select('id', 'title', 'permalink', 'publish_at')->get();
        return $articles;
    }
}
