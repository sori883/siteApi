<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\UseCase\Tag\FetchAllTagAction;
use App\UseCase\Tag\UpdateAction;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Tag\TagResource;

class TagController extends Controller
{
    /**
     * 全てのタグを取得する
     *
     * @param FetchAllTagAction $action
     * @return TagCollection
     */
    public function fetchAllTags(FetchAllTagAction $action): TagCollection
    {
        return new TagCollection($action());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag, UpdateAction $action)
    {
        $tagRequest = $request->makeTag();
        return new TagResource($action($tag, $tagRequest));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->articles()->detach();
        $tag->delete();
        return response(200);
    }
}
