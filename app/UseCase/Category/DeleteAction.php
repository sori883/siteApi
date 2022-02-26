<?php

namespace App\UseCase\Category;

use App\Models\Category;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __invoke(Category $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();

            DB::commit();
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
