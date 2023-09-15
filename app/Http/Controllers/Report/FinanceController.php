<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleDetailResource;
use App\Http\Resources\VoucherResource;
use App\Models\DailySale;
use App\Models\MonthlySale;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function monthlySale(Request $request)
    {

        $year = $request->year; // Replace with the desired year
        $month = $request->month;
        $startOfMonth =  Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $dailyVoucher = DailySale::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $totalVoucher = $dailyVoucher->sum('total_voucher');
        $cashTotal = $dailyVoucher->sum('total_cash');
        $taxTotal = $dailyVoucher->sum('tax_total');
        $total = $dailyVoucher->sum('total');
        $totalSale = $dailyVoucher->paginate(10)->withQueryString();
        SaleDetailResource::collection($totalSale);

        return response()->json([
            "monthly_total_sale" => [
                "total_voucher" => $totalVoucher,
                "total_cash" => $cashTotal,
                "total_tax" => $taxTotal,
                "total" => $total
            ],
            'data' => $totalSale
        ]);
    }

    public function yearlySale(Request $request)
    {

        $year = Carbon::create($request->year);
        $monthlyVoucher = MonthlySale::whereYear('created_at', $year)->get();
        $totalVoucher = $monthlyVoucher->sum('total_voucher');
        $cashTotal = $monthlyVoucher->sum('total_cash');
        $taxTotal = $monthlyVoucher->sum('tax_total');
        $total = $monthlyVoucher->sum('total');
        $data = SaleDetailResource::collection($monthlyVoucher);
        return response()->json([
            "yearly_sale" => [
                "total_voucher" => $totalVoucher,
                "total_cash" => $cashTotal,
                "total_tax" => $taxTotal,
                "total" => $total
            ],
            'data' => $data->resource
        ]);
    }

    public function customSearch(Request $request)
    {

        $from = $request->has('from') ? $request->from : Carbon::now()->setDay(1);
        $to = $request->has('to') ? $request->to : now();
        $dailyVoucher = Voucher::whereBetween('created_at', [$from, $to])->get();
        // return $dailyVoucher;
        $totalVoucher = $dailyVoucher->count('id');
        $total = $dailyVoucher->sum('total');
        $taxTotal = $dailyVoucher->sum('tax');
        $netTotal = $dailyVoucher->sum('net_total');

        $voucher = Voucher::whereBetween('created_at', [$from, $to])->latest("id")
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
}
