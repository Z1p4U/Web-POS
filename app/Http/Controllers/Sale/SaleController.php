<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleBrandResource;
use App\Http\Resources\SaleProductResource;
use App\Models\Brand;
use App\Models\DailySale;
use App\Models\MonthlySale;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function saleClose(Request $request)
    {
        $saleClose = Sale::find(1);
        if ($saleClose->sale_close) {
            return response()->json([
                "message" => "Already Closed"
            ]);
        }

        $date = now();

        // When sale close , it will add to daily table.
        $oldVoucherDate = DailySale::latest('id')->first();
        $dailyVoucher = Voucher::where('created_at', '>', $oldVoucherDate->updated_at)->get();
        // If already exit it will update depend on date.
        if ($oldVoucherDate->updated_at->day == $date->day) {
            $currentSale = DailySale::whereDate('created_at', $date)->first();
            $currentSale->total_voucher += $dailyVoucher->count('id');
            $currentSale->total_actual_price += $dailyVoucher->sum('total_actual_price');
            $currentSale->total_cash += $dailyVoucher->sum('total');
            $currentSale->tax_total += $dailyVoucher->sum('tax');
            $currentSale->total += $dailyVoucher->sum('net_total');
            $currentSale->update();
        } else {
            $totalVoucher = $dailyVoucher->count('id');
            $totalActualPrice = $dailyVoucher->sum('total_actual_price');
            $total = $dailyVoucher->sum('total');
            $taxTotal = $dailyVoucher->sum('tax');
            $netTotal = $dailyVoucher->sum('net_total');

            DailySale::create([
                "total_voucher" => $totalVoucher,
                "total_actual_price" => $totalActualPrice,
                "total_cash" => $total,
                "tax_total" => $taxTotal,
                "total" => $netTotal
            ]);
        }

        // End of the month it'll add to monthly table when you close sale.
        // $startOfMonth = $date->startOfMonth();
        // $endOfMonth = $startOfMonth->copy()->endOfMonth();
        // if($date->day == $endOfMonth->day){
        //     $sales = [];
        //     $monthlyVoucher = DailySale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        //     $totalVoucher = $monthlyVoucher->sum('total_voucher');
        //     $totalActualPrice = $monthlyVoucher->sum('total_actual_price');
        //     $cashTotal = $monthlyVoucher->sum('total_cash');
        //     $taxTotal = $monthlyVoucher->sum('tax_total');
        //     $total = $monthlyVoucher->sum('total');
        //     $sales[] = [
        //         "total_voucher" => $totalVoucher,
        //         "total_actual_price" => $totalActualPrice,
        //         "total_cash"  => $cashTotal,
        //         "tax_total" => $taxTotal,
        //         "total" => $total,
        //         "created_at" => $endOfMonth,
        //         "updated_at" => $endOfMonth
        //     ];
        //     MonthlySale::insert($sales);
        // }

        // Sale close controller
        $saleClose->sale_close = true;
        $saleClose->update();

        return response()->json([
            "data" => $saleClose,
            "message" => "Sale closed successfully"
        ]);
    }

    public function openSale(Request $request)
    {
        $saleClose = Sale::find(1);
        if (!$saleClose->sale_close) {
            return response()->json([
                "message" => "Already Opened"
            ]);
        }
        $saleClose->sale_close = false;
        $saleClose->update();

        return response()->json([
            "data" => $saleClose,
            "message" => "Opened Sale"
        ]);
    }

    public function saleProducts(Request $request)
    {
        $brandId = $request->brand_id;
        $products = Product::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;
                $builder->where("name", "LIKE", "%" . $keyword . "%");
            });
        })->when($request->has('brand_id'), function ($query) use ($brandId) {
            $query->where('brand_id', $brandId);
        })->latest('id')->get();

        if (empty($products->toArray())) {
            return response()->json([
                "message" => "There is no products"
            ]);
        }
        return SaleProductResource::collection($products);
    }

    public function saleBrands()
    {
        $brands = Brand::all();
        if (empty($brands->toArray())) {
            return response()->json([
                "message" => "There is no products yet!"
            ]);
        }
        return SaleBrandResource::collection($brands);
    }
}
