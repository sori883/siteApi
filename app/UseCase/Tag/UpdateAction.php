<?php

namespace App\UseCase\Tag;

use App\Models\Tag;

class UpdateAction
{
    public function __invoke(Tag $tag, array $tagRequest): Tag
    {
        // ドメインバリデーションとか

        // 記事登録
        $tag->fill($tagRequest);
        $tag->save();

        return $tag;
    }
}
