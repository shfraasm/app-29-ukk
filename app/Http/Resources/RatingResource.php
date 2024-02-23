<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'user_name' =>  $this->user->username ?? null,
            'book_id' => $this->book_id,
            'book_name' =>  $this->book->name ?? null,
            'description' => $this->description,
            'star' => $this->star,
            'created_at' => date_format($this->created_at, 'd, M Y')
            // format('d, M Y');
        ];
    }
}
