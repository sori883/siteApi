<?php

namespace App\UseCase\Category;

use App\Models\Category;

class UpdateAction
{
    public function __invoke(Category $category, array $categoryRequest): Category
    {
        // ドメインバリデーションとか

        // 記事登録
        $category->fill($categoryRequest);
        $category->save();

        return $category;
    }
}
