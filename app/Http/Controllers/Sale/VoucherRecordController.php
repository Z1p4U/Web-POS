<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\VoucherRecord;
use App\Http\Requests\StoreVoucherRecordRequest;
use App\Http\Requests\UpdateVoucherRecordRequest;
use App\Http\Resources\VoucherRecordResource;
use App\Http\Resources\VoucherResource;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $records = VoucherRecord::where("voucher_id", $request->voucher_id)
        //     ->latest("id");
        //     // ->paginate(10)
        //     // ->withQueryString();

        // if ($records->count()  === 0) {
        //     return response()->json([
        //         "message" => "There is no product yet"
        //     ]);
        // }


        // $records = Voucher::where("voucher_number", $request->voucher_number)->count('id');

        // return $records;
        // return VoucherRecordResource::collection($records);
    }

    public function showProductBasedOnVoucherNumber(Request $request)
    {
        $records = Voucher::where("voucher_number", $request->voucher_number)->first();
        if (is_null($records)) {
            return response()->json([
                "message" => "there is no records"
            ]);
        }
        return new VoucherResource($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRecordRequest $request)
    {
        $product = Product::find($request->product_id); // product wanted to sale
        // if there is no stock show error
        if ($product->total_stock === 0) {
            return response()->json([
                "message" => "out of stock"
            ]);
        }

        // $existedProduct = VoucherRecord::where('product_id', $request->product_id)->first();
        // if($existedProduct){
        //     $existedProduct->quantity = $quantity;
        // }

        $record = new VoucherRecord();
        $record->voucher_id = $request->voucher_id;
        $record->product_id = $request->product_id;
        $record->quantity = $request->quantity;
        $cost = $request->quantity * $product->sale_price; // product cost based on quantity
        $record->cost = $cost;
        // check voucher is available
        $voucher = Voucher::where("id", $request->voucher_id)->first();
        if (is_null($voucher)) {
            return response()->json([
                "message" => "there is no voucher yet"
            ], 404);
        };

        // updating voucher
        $voucher->total += $cost;
        $tax = $voucher->total * 0.05;
        $voucher->tax = $tax;
        $voucher->net_total = $voucher->total + $tax;
        $voucher->update();

        // updating product
        $product->total_stock -=  $request->quantity;
        $product->update();

        // save record
        $record->save();

        return response()->json([
            "message" => "your product is added to voucher.",
            "data" => $record
        ]);
    }

    // public function bulkStore(Request $request)
    // {
    //     $products = $request->products;
    //     if (is_array($products)) {
    //         foreach ($products as $product) {
    //             return $product;
    //         }
    //     }

    //     return "false";
    // }

    /**
     * Display the specified resource.
     */
    public function show(VoucherRecord $voucherRecord)
    {
        return $voucherRecord;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRecordRequest $request, string $id)
    {
        $recordedProduct = VoucherRecord::where('voucher_id', $id)->where('product_id', $request->product_id)->first();
        $product = Product::find($request->product_id); // product wanted to sale
        $voucher = Voucher::find($id);

        if (is_null($recordedProduct)) {
            return response()->json([
                "message" => "Not Found "
            ], 404);
        }

        // updating voucher
        $changedCost = $voucher->total;
        if ($request->quantity < $recordedProduct->quantity) {
            $quantity = $recordedProduct->quantity - $request->quantity;
            $changedCost -= $quantity * $product->sale_price;
            $product->total_stock += $quantity;
            $product->update();
        }
        if ($request->quantity > $recordedProduct->quantity) {
            $quantity = ($request->quantity - $recordedProduct->quantity);

            // return $changedCost;
            $changedCost += $quantity * $product->sale_price;
            $product->total_stock -= $quantity;
            $product->update();
        }
        $voucher->total = $changedCost;
        $tax = $voucher->total * 0.05;
        $voucher->tax = $tax;
        $voucher->net_total = $voucher->total + $tax;
        $voucher->update();

        // voucher records

        $recordedProduct->quantity = $request->quantity;
        $recordedProduct->cost = $request->quantity * $product->sale_price;
        $recordedProduct->update();

        return response()->json([
            "message" => "updated successfully",
            "data" => $recordedProduct
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $recordedProduct = VoucherRecord::where("voucher_id", $id)->where("product_id", $request->product_id)->first();
        if (is_null($recordedProduct)) {
            return response()->json([
                "message" => "Not Found "
            ], 404);
        }
        $voucher = Voucher::where("id", $recordedProduct->voucher_id)->first();
        $product = Product::find($request->product_id); // product wanted to sale

        if (is_null($product)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        // return $recordedProduct->product->sale_price;

        $cost = $recordedProduct->product->sale_price * $recordedProduct->quantity;
        $voucher->total -= $cost;
        $tax = $cost * 0.05;
        $voucher->tax -= $tax;
        $voucher->net_total -= $cost + $tax;
        $voucher->update();

        $product->total_stock += $recordedProduct->quantity;
        $product->update();

        $recordedProduct->delete();
        return response()->json([
            "message" => "deleted successfully"
        ]);
    }
}
