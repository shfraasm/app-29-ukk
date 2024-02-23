<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'photo' => env('APP_ASSETS_URL').$this->photo,
            'category' => $this->category,
            'total_rating' => $this->total_rating,
            'remaining_stock' => $this->remaining_stock,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'published_year' => $this->published_year,
        ];
    }
}
