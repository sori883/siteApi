<?php

namespace App\UseCase\Category;

use App\Models\Category;
use App\Models\User;

class StoreAction
{
    public function __invoke(Category $category, User $user): Category
    {
        // ドメインバリデーションとか
        // 名前重複とか

        // 記事更新
        $category->user_id = $user->id;
        $category->save();

        return $category;
    }
}
