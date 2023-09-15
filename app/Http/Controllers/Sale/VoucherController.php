<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Models\VoucherRecord;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $date = $request->has('date') ? $request->date : now();
        if (Auth::user()->role !== 'admin') {
            $date = now();
        }
        $dailyVoucher = Voucher::WhereDate('created_at', $date)->get();
        $totalVoucher = $dailyVoucher->count('id');
        $total = $dailyVoucher->sum('total');
        $taxTotal = $dailyVoucher->sum('tax');
        $netTotal = $dailyVoucher->sum('net_total');

        $voucher = Voucher::WhereDate('created_at', $date)->latest("id")
            ->paginate(10)
            ->withQueryString();

        $data =  VoucherResource::collection($voucher);



        return response()->json([
            "daily_total_sale" => [
                "total_voucher" => $totalVoucher,
                "total_cash" => $total,
                "total_tax" => $taxTotal,
                "total" => $netTotal
            ],
            "data" => $data->resource,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        // $request->validate([
        //     "voucher_number" => "required",
        //     "total" => "required",
        //     "tax" => "required",
        // ]);

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // $voucher = Voucher::create([
        //     "customer" => $request->customer,
        //     "phone" => $request->phone,
        //     "voucher_number" => $randomString,
        //     "total" => 0,
        //     "tax" => $request->total * ($request->tax / 100),
        //     "net_total" => $request->total + $request->total * ($request->tax / 100),
        //     "user_id" => $request->user_id,
        // ]);

        $voucher = new Voucher();
        // $customer = "unknown";
        if ($request->has('customer')) {
            $voucher->customer = $request->customer;
        }
        $voucher->phone = $request->phone;
        $voucher->voucher_number = $randomString;
        $total = 0;
        $voucher->total = $total;
        $voucher->tax = $voucher->total * 0.05;
        $voucher->net_total = $voucher->total + $voucher->tax;
        $voucher->user_id = Auth::id();

        $voucher->save();

        return response()->json([
            "data" => $voucher,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Voucher::find($id);
        if (is_null($product)) {
            return response()->json([
                "message" => "there is no voucher"
            ]);
        }
        return new VoucherResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, string $id)
    {
        $voucher = Voucher::find($id);
        if (is_null($voucher)) {
            return response()->json([
                "message" => "there is no voucher"
            ]);
        };

        $voucher->update([
            "customer" => $request->customer,
            "phone" => $request->phone,
            "voucher_number" => $request->voucher_number,
            "total" => $request->total,
            "tax" => $request->total * ($request->tax / 100),
            "net_total" => $request->total + $request->total * ($request->tax / 100),
            "user_id" => $request->user_id,
        ]);

        $voucher->update();

        return response()->json([
            "message" => "Updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::find($id);
        if (is_null($voucher)) {
            return response()->json([
                "message" => "Voucher not found",
            ], 404);
        }

        Gate::authorize("admin-only");

        $voucher->delete();

        return response()->json([
            "message" => "Voucher is deleted."
        ]);
    }
}
