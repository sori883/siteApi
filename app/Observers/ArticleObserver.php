<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    public $afterCommit = true;

    /**
     * Handle the Article "created" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function created()
    {
        Cache::tags(['article'])->flush();
    }

    /**
     * Handle the Article "updated" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function updated()
    {
        Cache::tags(['article'])->flush();
    }

    /**
     * Handle the Article "deleted" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function deleted()
    {
        Cache::tags(['article'])->flush();
    }
}
