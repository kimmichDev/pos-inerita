<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            "customer_name" => $this->customer_name,
            "voucher_number" => $this->voucher_number,
            "total" => $this->total,
            "created_at_time" => $this->created_at->format("h:i"),
            "created_at_date" => $this->created_at->format("d-M")
        ];
    }
}
