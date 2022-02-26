<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\Cache;

class FetchAllTagAction
{
    public function __invoke(int $currentPage): LengthAwarePaginator
    {
        try {
            $tags = Cache::tags(['tag', 'all'])->rememberForever('tagAll-' . $currentPage, function () {
                return Tag::select('id', 'text')
                ->paginate(50);
            });
            return $tags;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
