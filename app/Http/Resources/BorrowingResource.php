<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
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
            'user_name' =>  $this->user->name ?? null,
            'user_address' =>  $this->user->address ?? null,
            'book_id' => $this->book_id,
            'book_name' =>  $this->book->name ?? null,
            'book_photo' => env('APP_ASSETS_URL').$this->book->photo ?? null,
            'quantity' => $this->quantity,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ];
    }
}
