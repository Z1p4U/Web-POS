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
            "voucher_id" => $this->voucher_id,
            "product_id" => $this->product_id,
            "quantity" => $this->quantity,
            "cost" => $this->cost,
            "created_at" => $this->created_at->format("d m Y"),
            "updated_at" => $this->updated_at->format("d m Y"),
        ];
    }
}
