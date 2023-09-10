<?php

namespace App\Http\Resources;

use App\Models\VoucherRecord;
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
        $date = $request->has('date') ? $request->date : $this->created_at;
        return [
            "id" => $this->id,
            "customer" => $this->customer,
            "phone" => $this->phone,
            "voucher_number" => $this->voucher_number,
            "total_actual_price" => $this->total_actual_price,
            "total" => $this->total,
            "tax" => $this->tax,
            "net_total" => $this->net_total,
            "user_name" => $this->user->name,
            "item_count" => VoucherRecordResource::collection(VoucherRecord::whereDate("created_at", $date)->where('voucher_id', $this->id)->get())->count('id'),
            "records" => VoucherRecordResource::collection(VoucherRecord::whereDate("created_at", $date)->where('voucher_id', $this->id)->get()),
            "created_at" => $this->created_at->format("d M Y"),
            "created_time" => $this->created_at->format("h:m A"),
            "updated_at" => $this->updated_at->format("d M Y"),
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
