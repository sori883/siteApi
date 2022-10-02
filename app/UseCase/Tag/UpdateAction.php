<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    public function __invoke(Tag $tag, array $tagRequest): Tag
    {
        DB::beginTransaction();
        try {
            // 記事登録
            $tag->fill($tagRequest);
            $tag->save();

            DB::commit();

            return $tag;
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
