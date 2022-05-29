<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\Image\ImageStoreRequest;
use App\UseCase\Image\StoreAction;
use App\UseCase\Image\DeleteAction;
use App\UseCase\Image\FetchAllImageAction;
use App\UseCase\Image\FetchSelectorImage;
use App\Http\Resources\Image\ImageCollection;

class ImageController extends Controller
{
    /**
     * 全ての記事を取得する
     *
     * @param FetchAllArticleAction $action
     * @return ImageCollection
     */
    public function fetchAllImages(FetchAllImageAction $action): ImageCollection
    {
        $user = auth()->user();
        $currentPage = request()->get('page', 1);
        return new ImageCollection($action($user, $currentPage));
    }

    /**
     * 全ての記事を取得する
     *
     * @param FetchAllArticleAction $action
     * @return ImageCollection
     */
    public function fetchSelectorImage(FetchSelectorImage $action): ImageCollection
    {
        $user = auth()->user();
        $currentPage = request()->get('page', 1);
        return new ImageCollection($action($user, $currentPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageStoreRequest $request, StoreAction $action)
    {
        $images  = $request->images;
        $user = $request->user();
        return $action($images, $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image, DeleteAction $action)
    {
        $this->authorize('delete', $image);
        $action($image);
        return response(200);
    }
}
