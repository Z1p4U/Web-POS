<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            "customer" => $this->customer,
            "phone" => $this->phone,
            "voucher_number" => $this->voucher_number,
            "total" => $this->total,
            "tax" => $this->tax,
            "net_total" => $this->net_total,
            "user_name" => $this->user->name,
            "records" => $this->voucherRecords,
            "created_at" => $this->created_at->format("d m Y"),
            "created_time" => $this->created_at->format("h:m A"),
            "updated_at" => $this->updated_at->format("d m Y"),
        ];
        // return [
        //     "id" => $this->id,
        //     "voucher_id" => $this->voucher_id,
        //     "product_id" => $this->product_id,
        //     "quantity" => $this->quantity,
        //     "cost" => $this->cost,
        //     "created_at" => $this->created_at->format("d m Y"),
        //     "updated_at" => $this->updated_at->format("d m Y"),
        // ];
    }
}
