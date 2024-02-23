<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            'user_id' =>  $this->user_id,
            'username' =>  $this->user->username ?? null,
            'book_id' => $this->book_id,
            'book_name' =>  $this->book->name ?? null,
            'book_photo' => env('APP_ASSETS_URL').$this->book->photo ?? null,
        ];
    }
}
