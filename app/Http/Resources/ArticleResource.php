<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'created_at' => $this->resource->created_at,
            'user_id' => $this->resource->user_id,
            'image_id' => $this->resource->image_id,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
