<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => ArticleListResource::collection($this->collection),
            'lastPage' => $this->lastPage() // ページャーの最終ページ
        ];
    }
}
