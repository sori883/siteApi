<?php

namespace App\UseCase\Category;

use App\Models\Category;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    public function __invoke(Category $category, array $categoryRequest): Category
    {
        DB::beginTransaction();
        try {
            // 記事登録
            $category->fill($categoryRequest);
            $category->save();

            DB::commit();

            return $category;
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
