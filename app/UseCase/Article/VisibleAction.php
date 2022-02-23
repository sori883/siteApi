<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class VisibleAction
{
    public function __invoke(Article $article)
    {
        DB::beginTransaction();
        try {
            $article->publish_at = !$article->publish_at ? true : false;
            $article->save();

            DB::commit();

            return $article;
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
