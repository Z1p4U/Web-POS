<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
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
        })->when(request()->has('id'), function ($query) {
            $sortType = request()->id ?? 'asc';
            $query->orderBy("id", $sortType);
        })->when(request()->has('name'), function ($query) {
            $sortType = request()->name ? 'desc' : 'asc';
            $query->orderBy("name", $sortType);
        })
            ->latest("id")
            ->paginate(10)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $brand = Brand::where('id', $request->brand_id)->first();
        if (is_null($brand)) {
            return response()->json([
                "message" => "there is no brand name like that"
            ]);
        };
        $product->brand_id = $request->brand_id;
        $product->user_id = Auth::id();
        $product->actual_price = $request->actual_price;
        $product->sale_price = $request->sale_price;
        $product->unit = $request->unit;
        // $product->total_stock = 0;
        $product->more_information = $request->more_information;
        // $product->photo = Photo::find(1)->url;
        $product->photo = $request->photo;

        $product->save();
        return response()->json([
            "data" => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json([
                "message" => "there is no product"
            ]);
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json([
                "message" => "there is no product"
            ]);
        };

        // $this->authorize('update', $product);
        if (Gate::denies('update', $product)) {
            return response()->json([
                "message" => "you are no allowed"
            ]);
        }

        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->user_id = Auth::id();
        $product->actual_price = $request->actual_price;
        $product->sale_price = $request->sale_price;
        $product->unit = $request->unit;
        $product->more_information = $request->more_information;
        if ($request->has('photo')) {
            $product->photo = $request->photo;
        }

        $product->update();

        return response()->json([
            "message" => "Updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize("delete");
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json([
                "message" => "there is no product to delete"
            ], 404);
        }
        if (Gate::denies('delete', $product)) {
            return response()->json([
                "message" => "you are no allowed"
            ]);
        }
        $product->delete();
        return response()->json([
            "message" => "deleted product successfully"
        ]);
    }
}
