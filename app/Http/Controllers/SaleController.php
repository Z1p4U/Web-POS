<?php

namespace App\Http\Controllers;

use App\Models\DailySale;
use App\Models\Sale;
use App\Models\Voucher;
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
        $saleClose->sale_close = true;
        $saleClose->update();


        $date = now();
        $dailyVoucher = Voucher::WhereDate('created_at', $date)->get();
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
}
