<?php

namespace App\UseCase\Article;

use App\Models\Article;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __invoke(Article $article)
    {
        DB::beginTransaction();

        try {
            $article->tags()->detach();
            $article->delete();

            DB::commit();
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
