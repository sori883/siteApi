<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class FetchAllTagAction
{
    public function __invoke(): Collection
    {
        $tags = Tag::select('id', 'name')->get();
        return $tags;
    }
}
