<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::when(request()->has('keyword'), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;
                $builder->where('name', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create([
            'name' => $request->name,
            'company' => $request->company,
            'agent' => $request->agent,
            'phone' => $request->phone,
            'user_id' => Auth::id(),
            'description' => $request->description,
            // 'photo' => Photo::find(1)->url,
            'photo' => $request->photo
        ]);

        return response()->json([
            'message' => 'created successfully',
            'data' => $brand,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);
        if (is_null($brand)) {
            return response()->json([
                'message' => 'nothing to show',
            ], 404);
        }

        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = Brand::find($id);

        if (is_null($brand)) {
            return response()->json([
                'message' => 'nothing to show',
            ], 404);
        }

        $brand->name = $request->name;
        $brand->company = $request->company;
        $brand->agent = $request->agent;
        $brand->phone = $request->phone;
        $brand->description = $request->description;
        $brand->photo = $request->photo;
        $brand->update();
        return response()->json([
            'message' => 'updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);

        if (is_null($brand)) {
            return response()->json([
                'message' => 'nothing to show',
            ], 404);
        }

        if (Gate::denies('delete', $brand)) {
            return response()->json([
                'message' => 'you are no allowed',
            ]);
        }

        $brand->delete();

        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
