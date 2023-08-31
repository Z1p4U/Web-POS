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
        $startOfMonth = Carbon::now()->subYear();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $year = $startOfMonth->year;
        $sales = [];
        for ($i = $startOfMonth->month; Carbon::create($year, $startOfMonth->month, 1) != Carbon::now()->month; $i++) {
            $dailyVoucher = DailySale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
            $totalVoucher = $dailyVoucher->sum('total_voucher');
            $cashTotal = $dailyVoucher->sum('total_cash');
            $taxTotal = $dailyVoucher->sum('tax_total');
            $total = $dailyVoucher->sum('total');
            $sales[] = [
                "total_voucher" => $totalVoucher,
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
