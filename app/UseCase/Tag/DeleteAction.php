<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __invoke(Tag $tag)
    {
        DB::beginTransaction();
        try {
            $tag->articles()->detach();
            $tag->delete();

            DB::commit();
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
