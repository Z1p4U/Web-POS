<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetailResource extends JsonResource
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
            "total_voucher" => $this->total_voucher,
            "total_cash" => $this->total_cash,
            "tax_total" => $this->tax_total,
            "total" => $this->total,
            "created_at" => $this->created_at->format('d M Y'),
            "updated_at" => $this->updated_at->format('d M Y')
        ];
    }
}
