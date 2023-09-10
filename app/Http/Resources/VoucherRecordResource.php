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
            "actual_price" => $this->product->actual_price,
            "sale_price" => $this->product->sale_price,
            "quantity" => $this->quantity,
            "cost" => $this->cost,
            "created_at" => $this->created_at->format("d M Y"),
        ];
    }
}
