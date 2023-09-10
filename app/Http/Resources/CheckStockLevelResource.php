<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckStockLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stockLevel = "In Stock";
        if ($this->total_stock < 100) {
            $stockLevel = "Low Stock";
        }
        if ($this->total_stock == 0) {
            $stockLevel = "Out of Stock";
        }
        return [
            "id" => $this->id,
            "name" => $this->name,
            "brand_name" => $this->brand->name,
            "user_id" => $this->user_id,
            "actual_price" => $this->actual_price,
            "sale_price" => $this->sale_price,
            "total_stock" => $this->total_stock,
            "unit" => $this->unit,
            "stock_level" => $stockLevel,
            "updated_at" => $this->updated_at->format('d m Y'),
            "created_at" => $this->created_at->format('d m Y')
        ];
    }
}
