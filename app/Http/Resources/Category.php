<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    public function toArray($request)
    {
        $data =  [
            'id' => $this->id,
            'name' => $this->name
        ];

        if ($request->with_posts) {
            $data['posts'] = $this->posts;
        }

        return $data;
    }
}
