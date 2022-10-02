<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Collection;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    public function __invoke(
        Article $article,
        array $articleRequest,
        ?Collection $tags,
        ?Category $category,
        ?Image $image
    ): Article {
        DB::beginTransaction();
        try {
            // 記事登録
            $article->fill($articleRequest);
            $article->category_id = $category ? $category->id : null;
            $article->image_id = $image ? $image->id : null;
            $article->save();

            // タグ登録
            if ($tags) {
                $article->tags()->detach();
                $tags->each(function ($tagName) use ($article) {
                    $tag = Tag::firstOrCreate(['text' => $tagName]);
                    $article->tags()->attach($tag);
                });
            }

            DB::commit();

            return $article;
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
