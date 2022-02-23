<?php

namespace App\UseCase\Tag;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class FetchAllTagAction
{
    public function __invoke(): LengthAwarePaginator
    {
        $tags = Tag::select('id', 'text')
        ->paginate(50);
        return $tags;
    }
}
