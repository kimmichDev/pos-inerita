<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            "id" => $this->id,
            "name" => ucfirst($this->name),
            "price" => $this->price,
            "category_id" => $this->category_id,
            "category" => $this->category,
            "photo" => asset("storage/item-photo/" . $this->photo),
            "created_at_date" => $this->created_at->format('d-M-Y'),
            "created_at_time" => $this->created_at->format('h:m:i a')
        ];
    }
}
