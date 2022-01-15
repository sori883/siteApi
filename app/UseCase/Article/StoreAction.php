<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

class StoreAction
{
    public function __invoke(Article $article, User $user, Collection $tags): Article
    {
        // ドメインバリデーションとか
        // パーマリンクとかのね

        // 記事登録
        $article->user_id = $user->id;
        $article->save();

        // タグ登録
        $tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return $article;
    }
}
