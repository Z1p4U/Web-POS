<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Http\Resources\VoucherResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = Voucher::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;

                $builder->where("name", "LIKE", "%" . $keyword . "%");
                $builder->orWhere("brand", "LIKE", "%" . $keyword . "%");
            });
        })
            ->latest("id")
            ->paginate(10)
            ->withQueryString();

        return VoucherResource::collection($voucher);
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

        $voucher = Voucher::create([
            "customer" => $request->customer,
            "phone" => $request->phone,
            "voucher_number" => $request->voucher_number,
            "total" => $request->total,
            "tax" => $request->total * ($request->tax / 100),
            "net_total" => $request->total - $request->total * ($request->tax / 100),
            "user_id" => $request->user_id,
        ]);

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
