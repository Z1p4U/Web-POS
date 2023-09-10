<?php

namespace Database\Seeders;

use App\Models\DailySale;
use App\Models\MonthlySale;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonthlySaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startOfMonth = Carbon::create(2022, 9, 1);
        $sales = [];
        for ($i = 1; $startOfMonth->format("M Y") != Carbon::now()->format("M Y"); $i++) {
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $dailyVoucher = DailySale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
            $totalVoucher = $dailyVoucher->sum('total_voucher');
            $totalActualPrice = $dailyVoucher->sum('total_actual_price');
            $cashTotal = $dailyVoucher->sum('total_cash');
            $taxTotal = $dailyVoucher->sum('tax_total');
            $total = $dailyVoucher->sum('total');
            $sales[] = [
                "total_voucher" => $totalVoucher,
                "total_actual_price" => $totalActualPrice,
                "total_cash"  => $cashTotal,
                "tax_total" => $taxTotal,
                "total" => $total,
                "created_at" => $endOfMonth,
                "updated_at" => $endOfMonth
            ];
            $startOfMonth->addMonth();
        }
        MonthlySale::insert($sales);
    }
}
