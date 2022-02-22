<?php

namespace App\UseCase\Article;

use App\Models\Article;

class DeleteAction
{
    public function __invoke(Article $article)
    {
        $article->tags()->detach();
        $article->delete();
    }
}
