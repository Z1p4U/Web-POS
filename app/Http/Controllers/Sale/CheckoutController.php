<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherResource;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use App\Rules\CheckProductQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function run(Request $request)
    {
        try {
            DB::beginTransaction();

            // Perform database operations here
            $productIds = collect($request->items)->pluck("product_id");
            $products = Product::whereIn("id", $productIds)->get(); // use database
            $totalActualPrice = 0;
            $total = 0;

            foreach ($request->items as $item) {
                $currentProduct = $products->find($item["product_id"]);
                if (is_null($currentProduct)) {
                    return response()->json([
                        "message" => "there is no product"
                    ]);
                }
                $totalActualPrice += $item["quantity"] * $currentProduct->actual_price;
                $total += $item["quantity"] * $currentProduct->sale_price;
            }
            $tax = $total * 0.05;
            $netTotal = $total + $tax;

            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';

            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $voucher = Voucher::create([
                "voucher_number" => $randomString,
                "total_actual_price" => $totalActualPrice,
                "total" => $total,
                "tax" => $tax,
                "net_total" => $netTotal,
                "user_id" => Auth::id(),
            ]); // use database

            $records = [];

            $request->validate([
                'items' => ['required', 'array', new CheckProductQuantity]
            ]);

            foreach ($request->items as $item) {

                $currentProduct = $products->find($item["product_id"]);
                $records[] = [
                    "voucher_id" => $voucher->id,
                    "product_id" => $item["product_id"],
                    "actual_price" => $currentProduct->actual_price,
                    "price" => $currentProduct->sale_price,
                    "quantity" => $item["quantity"],
                    "cost" => $item["quantity"] * $currentProduct->sale_price,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
                Product::where("id", $item["product_id"])->update([
                    "total_stock" => $currentProduct->total_stock - $item["quantity"]
                ]);
            }

            $voucherRecords = VoucherRecord::insert($records); // use database
            // dd($voucherRecords);
            // return $request;

            DB::commit();
            return response()->json([
                'message' => 'checkout successfully',
                "data" => new VoucherResource($voucher)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.', 'error' => $e->getMessage()], 500);
        }
    }
}
