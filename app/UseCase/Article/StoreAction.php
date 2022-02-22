<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

class StoreAction
{
    public function __invoke(Article $article, User $user, Collection $tags, Category $category): Article
    {
        // 記事更新
        $article->user_id = $user->id;
        $article->category_id = $category->id;
        $article->save();

        // タグ登録
        $tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['text' => $tagName]);
            $article->tags()->attach($tag);
        });

        return $article;
    }
}
