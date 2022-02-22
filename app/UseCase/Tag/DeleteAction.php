<?php

namespace App\UseCase\Tag;

use App\Models\Tag;

class DeleteAction
{
    public function __invoke(Tag $tag)
    {
        $tag->articles()->detach();
        $tag->delete();
    }
}
