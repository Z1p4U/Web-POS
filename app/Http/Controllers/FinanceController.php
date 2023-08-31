<?php

namespace App\Http\Controllers;

use App\Models\DailySale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function monthlySale(Request $request)
    {
        $year = $request->year; // Replace with the desired year
        $month = $request->month;
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        // return $endOfMonth->format('d M Y');

        return (Carbon::now()->startOfMonth()->month == Carbon::now()->subYear()->startOfMonth()->month);
        $month = $request->month;
        $year = $request->year;
        $monthNo = $request->has('month') ? $month : now();
        $yearNo = $request->has('year') ? $year : now();
        $dailyVoucher = DailySale::whereBetween('created_at', [$startOfMonth , $endOfMonth])->get();
        $totalVoucher = $dailyVoucher->sum('total_voucher');
        $cashTotal = $dailyVoucher->sum('total_cash');
        $taxTotal = $dailyVoucher->sum('tax_total');
        $total = $dailyVoucher->sum('total');

        return response()->json([
            "monthly_total_sale" => [
                "total_voucher" => $totalVoucher,
                "total_cash" => $cashTotal,
                "total_tax" => $taxTotal,
                "total" => $total
            ],

        ]);
    }
}
