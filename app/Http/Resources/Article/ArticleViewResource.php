<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryListResource;
use App\Http\Resources\Tag\TagResource;

class ArticleViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'entry' => $this->resource->entry,
            'permalink' => $this->resource->permalink,
            'publish_at' => $this->resource->publish_at,
            'category' => CategoryListResource::make($this->resource->category),
            'tags' => TagResource::collection($this->resource->tags),
        ];
    }
}
