<?php

namespace App\UseCase\Image;

use App\Models\Image;
use App\Exceptions\ExclusiveLockException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\StorageException;

class DeleteAction
{
    public function __invoke(Image $image)
    {
        DB::beginTransaction();

        try {
            $image->delete();
        } catch (ExclusiveLockException $e) {
            DB::rollback();
            throw $e;
        }

        // 画像削除
        try {
            Storage::delete($image->path);
        } catch (StorageException $e) {
            throw $e;
        }

        DB::commit();
    }
}
