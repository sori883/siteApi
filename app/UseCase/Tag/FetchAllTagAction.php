<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;

class FetchAllTagAction
{
    public function __invoke(): LengthAwarePaginator
    {
        try {
            $tags = Tag::select('id', 'text')
            ->paginate(50);
            return $tags;
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }
    }
}
