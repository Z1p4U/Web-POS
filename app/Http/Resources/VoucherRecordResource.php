<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "product_name" => $this->product->name,
            "voucher_number" => $this->voucher->voucher_number,
            "sale_price" => $this->product->sale_price,
            "quantity" => $this->quantity,
            "cost" => $this->cost
        ];
    }
}
