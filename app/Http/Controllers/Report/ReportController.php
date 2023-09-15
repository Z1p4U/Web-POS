<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\CheckStockLevelResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReportSaleResource;
use App\Http\Resources\TodaySaleProductReportResource;
use App\Models\Brand;
use App\Models\DailySale;
use App\Models\MonthlySale;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherRecord;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function overview(Request $request)
    {
        $totalStock = Product::all()->sum('total_stock');
        $totalStaff = User::all()->count('id');
        // Default for Week
        $startOfDay =  Carbon::now()->startOfWeek();
        $endOfDay = $startOfDay->copy()->endOfWeek();
        $totalSale = DailySale::whereBetween('created_at', [$startOfDay, $endOfDay])->get();
        // Yearly Sale Chart
        if ($request->has('year')) {
            $totalSale =  MonthlySale::whereYear('created_at', now())->get();
        }

        // Monthly Sale Chart
        if ($request->has('month')) {
            $startOfMonth =  Carbon::create(now()->year, now()->month, 1);
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $totalSale = DailySale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        }

        $total = $totalSale->sum('total_cash');
        $totalActualPrice = $totalSale->sum('total_actual_price');
        $totalProfit = $total - $totalActualPrice;
        $totalSale = ReportSaleResource::collection($totalSale);
        return response()->json([
            "totalStock" => $totalStock,
            "totalStaff" => $totalStaff,
            "total" => $total,
            "total_profit" => $totalProfit,
            "total_income" => $total,
            "total_expense" => $totalActualPrice,
            "total_sales" => $totalSale,
        ]);
    }

    public function saleReport(Request $request)
    {
        // Default for Week
        $startOfDay =  Carbon::now()->startOfWeek();
        $endOfDay = $startOfDay->copy()->endOfWeek();
        $totalSale = DailySale::whereBetween('created_at', [$startOfDay, $endOfDay])->get();


        // Brand total Sale
        // Default date
        $brandDate = null;
        if ($request->has('month')) {
            $brandDate = "month";
        }
        if ($request->has('year')) {
            $brandDate = "year";
        }

        // Yearly Sale Chart
        if ($request->has('year')) {
            $totalSale =  MonthlySale::whereYear('created_at', now())->get();
        }

        // Monthly Sale Chart
        if ($request->has('month')) {
            $startOfMonth =  Carbon::create(now()->year, now()->month, 1);
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $totalSale = DailySale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        }

        // Duration Filter Sales
        $total = $totalSale->sum('total_cash');
        $totalActualPrice = $totalSale->sum('total_actual_price');
        $totalProfit = $total - $totalActualPrice;
        $maximumPrice = $totalSale->where('total_cash', $totalSale->max('total_cash'))->first();
        $averagePrice = $totalSale->avg('total_cash');
        $minimumPrice = $totalSale->where('total_cash', $totalSale->min('total_cash'))->first();
        $totalSale = ReportSaleResource::collection($totalSale);

        // Today Sales
        $date = now();
        $todaySaleProducts = Voucher::whereDate('created_at', $date)->get();
        $todayTotal = $todaySaleProducts->sum('total');
        $todayMaxSale = $todaySaleProducts->where('total', $todaySaleProducts->max('total'))->first();
        $todayAvgSale = $todaySaleProducts->avg('total');
        $todayMinSale = $todaySaleProducts->where('total', $todaySaleProducts->min('total'))->first();

        // Product Sale
        $products = Product::when(request()->has('price'), function ($query) {
            $query->orderBy("sale_price", 'asc');
        })->orderBy('sale_price', 'desc')->limit(5)->get();

        return response()->json([
            "today_sales" => empty($todaySaleProducts->toArray()) ? ["total" => $todayTotal, "message" => "No Voucher!"] : [
                "total" => $todayTotal,
                "today_max_sale" => new TodaySaleProductReportResource($todayMaxSale),
                "today_avg_sale" => round($todayAvgSale),
                "today_min_sale" => new TodaySaleProductReportResource($todayMinSale),
            ],

            "brand_sales" => $this->brandSales($brandDate),

            "sales" => [
                "total" => $total,
                "total_profit" => $totalProfit,
                "max_price" => new ReportSaleResource($maximumPrice),
                "avg_price" => round($averagePrice),
                "min_price" => new ReportSaleResource($minimumPrice),
                "total_sales" => $totalSale,
            ],
            "products" => ProductResource::collection($products)
        ]);
    }

    public function brandReport()
    {
        $totalProducts = Product::all()->count('id');
        $totalBrands = Brand::all()->count('id');
        $totalProducts = Product::all()->count('id');
        $inStock = Product::where('total_stock', '>', 100)->get()->count('id');
        $lowStock = Product::whereBetween('total_stock', [1, 100])->get()->count('id');
        $outOfStock = Product::where('total_stock', '=', 0)->get()->count('id');


        return response()->json([
            "total_products" => $totalProducts,
            "total_brands" => $totalBrands,
            "brands" =>  $this->brandSales(), // from branSales function
            "stocks" => [
                "in_stock" => ($inStock / $totalProducts) * 100 . '%',
                "low_stock" => ($lowStock / $totalProducts) * 100 . '%',
                "out_of_stock" => ($outOfStock / $totalProducts) * 100 . '%',
            ]
        ]);
    }

    public function stockReport()
    {
        $products = Product::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;
                $builder->where("name", "LIKE", "%" . $keyword . "%");
            });
        })->when(request()->has('id'), function ($query) {
            $sortType = request()->id ?? 'asc';
            $query->orderBy("id", $sortType);
        })->when(request()->has('name'), function ($query) {
            $sortType = request()->name ? 'desc' : 'asc';
            $query->orderBy("name", $sortType);
        })->when(request()->has('in-stock'), function ($query) {
            $query->where('total_stock', '>', 100);
        })->when(request()->has('low-stock'), function ($query) {
            $query->whereBetween('total_stock', [1, 100]);
        })->when(request()->has('out-of-stock'), function ($query) {
            $query->where('total_stock', '=', 0);
        })
            ->latest("id")
            ->paginate(10)
            ->withQueryString();

        return CheckStockLevelResource::collection($products);
    }

    // REUSABLE FUNCTION
    // Brand Sales depends on Date
    private function brandSales($date = null)
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();
        if ($date === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        }
        if ($date == 'year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = $startDate->copy()->endOfYear();
        }
        $brands = Brand::get()->pluck('name', 'id')->toArray();
        $totalBrand = [];
        foreach ($brands as $brandId => $brandName) {
            // Get best seller brand
            $saleBrand = VoucherRecord::whereBetween('created_at', [$startDate, $endDate])
                ->whereHas('product', function ($query) use ($brandId) {
                    $query->where('brand_id', $brandId);
                })
                ->get();

            $totalBrand[] = [
                "brand_name" => $brandName,
                "total_brand_sale" => $saleBrand->sum('quantity'),
                "total_sale" => $saleBrand->sum('cost')
            ];
        }
        return $totalBrand;
    }
}
