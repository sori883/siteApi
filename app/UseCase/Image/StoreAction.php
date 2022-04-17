<?php

namespace App\UseCase\Image;

use Illuminate\Support\Facades\Storage;
use App\Exceptions\StorageException;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Exceptions\ExclusiveLockException;

class StoreAction
{
    public function __invoke(array $images, User $user)
    {
        $paths = array();
        // 画像アップロード
        try {
            foreach ($images as $image) {
                // アップロードフォルダを年単位で分割
                $paths[] =  [
                    'path' => Storage::put(Carbon::now()->year, $image),
                    'title' => $image->getClientOriginalName()
                ];
            }
        } catch (StorageException $e) {
            throw $e;
        }

        DB::beginTransaction();
        // DB登録
        try {
            foreach ($paths as $path) {
                $model = Image::create($path);
                $model->user_id = $user->id;
                $model->save();
            }
        } catch (ExclusiveLockException $e) {
            throw $e;
            DB::rollback();
        }

        DB::commit();
    }
}
