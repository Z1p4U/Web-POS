<?php

namespace App\Http\Controllers;

use App\Models\VoucherRecord;
use App\Http\Requests\StoreVoucherRecordRequest;
use App\Http\Requests\UpdateVoucherRecordRequest;
use App\Http\Resources\VoucherRecordResource;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class VoucherRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($request)
    {
        $records = VoucherRecord::where("voucher_id", $request->voucher_id)
            ->latest("id")
            ->paginate(10)
            ->withQueryString();

        if ($records->count()  === 0) {
            return response()->json([
                "message" => "There is no product yet"
            ]);
        }

        return VoucherRecordResource::collection($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRecordRequest $request)
    {
        $record = new VoucherRecord();
        $record->voucher_id = $request->product_id;
        $record->product_id = $request->product_id;
        $record->quantity = $request->quantity;
        $record->cost = $request->cost;

        $voucher = Voucher::where("id", $request->voucher_id)->first();
        if (is_null($voucher)) {
            return response()->json([
                "message" => "there is no product yet"
            ]);
        };
        $voucher->voucher_number = $voucher->voucher_number + $request->quantity;
        $voucher->total = $voucher->total + $request->cost;
        $voucher->update();

        $record->save();

        return response()->json([
            "message" => "your product is added to voucher."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(VoucherRecord $voucherRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRecordRequest $request, VoucherRecord $voucherRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VoucherRecord $voucherRecord)
    {
        //
    }
}
