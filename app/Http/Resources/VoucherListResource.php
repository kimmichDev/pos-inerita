<?php

namespace App\Http\Resources;

use App\Models\VoucherList;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherListResource extends JsonResource
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
            "item_name" => $this->item_name,
            "unit_price" => $this->unit_price,
            "voucher_id" => $this->voucher_id,
            "quantity" => $this->quantity,
            "cost" => $this->cost,
        ];
    }
}
