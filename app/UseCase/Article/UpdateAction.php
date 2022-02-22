<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Collection;

class UpdateAction
{
    public function __invoke(Article $article, array $articleRequest, Collection $tags, Category $category): Article
    {
        // 記事登録
        $article->fill($articleRequest);
        $article->category_id = $category->id;
        $article->save();

        // タグ登録
        $article->tags()->detach();
        $tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['text' => $tagName]);
            $article->tags()->attach($tag);
        });

        return $article;
    }
}
