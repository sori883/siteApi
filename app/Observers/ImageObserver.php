<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ImageObserver
{
    /**
     * Handle the Image "created" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function created()
    {
        Cache::tags(['image'])->flush();
    }

    /**
     * Handle the Image "updated" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function updated()
    {
        Cache::tags(['image'])->flush();
    }

    /**
     * Handle the Image "deleted" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function deleted()
    {
        Cache::tags(['image'])->flush();
    }
}
