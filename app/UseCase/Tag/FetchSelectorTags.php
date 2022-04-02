<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FetchSelectorTags
{
    public function __invoke(): Collection
    {
        try {
            $tags = Cache::tags(['tag', 'selector'])->rememberForever('CategorySelector', function () {
                return Tag::select('id', 'text')->get();
            });
            return $tags;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
