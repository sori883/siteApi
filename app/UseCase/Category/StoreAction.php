<?php

namespace App\UseCase\Category;

use App\Models\Category;
use App\Models\User;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    public function __invoke(Category $category, User $user): Category
    {
        DB::beginTransaction();

        try {
            // 記事更新
            $category->user_id = $user->id;
            $category->save();

            DB::commit();

            return $category;
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
