<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Resources\StockResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;

                $builder->where("name", "LIKE", "%" . $keyword . "%");
            });
        });
        $stocks = Stock::whereIn('product_id', $products->pluck('id'))
            ->when(request()->has('id'), function ($query) {
                $sortType = request()->id ?? 'asc';
                $query->orderBy("id", $sortType);
            })->latest("id")
            ->paginate(10)
            ->withQueryString();

        if ($stocks->count()  === 0) {
            return response()->json([
                "message" => "There is no products yet"
            ]);
        }
        return StockResource::collection($stocks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $stock = new Stock();
        $stock->user_id = Auth::id();
        $stock->product_id = $request->product_id;
        $stock->quantity = $request->quantity;
        $stock->more = $request->more;

        $product = Product::where("id", $request->product_id)->first();
        if (is_null($product)) {
            return response()->json([
                "message" => "there is no product yet"
            ], 404);
        };
        $product->total_stock = $product->total_stock + $request->quantity;
        $product->update();

        $stock->save();

        return response()->json([
            "message" => "your product is ready to sell"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
