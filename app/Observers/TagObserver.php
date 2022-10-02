<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class TagObserver
{
    public $afterCommit = true;

    /**
     * Handle the Tag "created" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function created()
    {
        Cache::tags(['tag'])->flush();
    }

    /**
     * Handle the Tag "updated" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function updated()
    {
        Cache::tags(['tag'])->flush();
    }

    /**
     * Handle the Tag "deleted" event.
     *
     * @param  \App\Models\Tag  $tag
     * @return void
     */
    public function deleted()
    {
        Cache::tags(['tag'])->flush();
    }
}
