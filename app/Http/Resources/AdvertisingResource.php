<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->conditionalFieldSelect('description'),
            'price' => $this->price,
            'main_image_url' => $this->main_image_url,
            'images' => ImageResource::collection($this->conditionalFieldSelect('images')),
        ];
    }

    public function conditionalFieldSelect(string $fieldName)
    {
        return $this->when(in_array($fieldName, request()->get('fields', [])), $this->{$fieldName});
    }
}
