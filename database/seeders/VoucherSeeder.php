<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subYear();

        $period = CarbonPeriod::create($startDate, $endDate);
        $id = 1;
        foreach ($period as $index => $day) {
            $vouchers = [];

            for ($i = 1; $i <= 2; $i++) {
                $ids = [];
                $productId = random_int(1, 6);
                for ($y = 1; $y <= $productId; $y++) {
                    $ids[] = random_int(1, 20);
                }
                $products = Product::whereIn('id', $ids)->get();
                $total = 0;

                $records = [];
                foreach ($ids as $itemId) {
                    $quantity = random_int(1, 5);
                    $total += $quantity * $products->find($itemId)->sale_price;

                    $currentProduct = $products->find($itemId);
                    $records[] = [
                        "voucher_id" => $id,
                        "product_id" => $itemId,
                        "price" => $products->find($itemId)->sale_price,
                        "quantity" => $quantity,
                        "cost" => $quantity * $currentProduct->sale_price,
                        "created_at" => $day,
                        "updated_at" => $day
                    ];
                    Product::where("id", $itemId)->update([
                        "total_stock" => $currentProduct->total_stock - $quantity
                    ]);
                }
                VoucherRecord::insert($records); // use database

                $tax = $total * 0.05;
                $netTotal = $total + $tax;
                $vouchers[] = [
                    "voucher_number" => (2 * $index) + 45,
                    "total" => $total,
                    "tax" => $tax,
                    "net_total" => $netTotal,
                    "user_id" => 1,
                    "created_at" => $day,
                    "updated_at" => $day
                ];
                $id++;
            }
            Voucher::insert($vouchers);
        }
    }
}
