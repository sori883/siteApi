<?php

namespace App\UseCase\Article;

use App\Models\Article;

class VisibleAction
{
    public function __invoke(Article $article)
    {
        $article->publish_at = !$article->publish_at ? true : false;
        $article->save();

        return $article;
    }
}
