<?php

namespace Database\Seeders;

use App\Models\DailySale;
use App\Models\Voucher;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailySaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $endDate = Carbon::now();
        $startDate = Carbon::create(2022, 7, 1);

        $period = CarbonPeriod::create($startDate, $endDate);
        $DailyTotalSale = [];
        foreach ($period as $day) {
            $date = $day;
            $dailyVoucher = Voucher::WhereDate('created_at', $date)->get();
            $totalVoucher = $dailyVoucher->count('id');
            $totalActualPrice = $dailyVoucher->sum('total_actual_price');
            $total = $dailyVoucher->sum('total');
            $taxTotal = $dailyVoucher->sum('tax');
            $netTotal = $dailyVoucher->sum('net_total');
            $DailyTotalSale[] = [
                "total_voucher" => $totalVoucher,
                "total_actual_price" => $totalActualPrice,
                "total_cash" => $total,
                "tax_total" => $taxTotal,
                "total" => $netTotal,
                "created_at" => $day,
                "updated_at" => $day
            ];
        }
        DailySale::insert($DailyTotalSale);
    }
}
