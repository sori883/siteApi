<?php

namespace App\UseCase\Image;

use App\Models\Image;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\Cache;

class FetchSelectorImage
{
    public function __invoke(User $user, int $currentPage): LengthAwarePaginator
    {
        try {
            $articles = Cache::tags(['image', 'all'])
                ->rememberForever('FetchSelectorImage-' . $currentPage, function () use ($user) {
                    return Image::select('id', 'title', 'path')
                    ->where('user_id', $user->id)
                    ->paginate(15);
                });
            return $articles;
        } catch (ExclusiveLockException $e) {
            throw $e;
        }
    }
}
