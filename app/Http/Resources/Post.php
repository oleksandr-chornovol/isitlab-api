<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'image' => $this->image,
            'categories' => $this->categories()->pluck('category_id')
        ];
    }
}
