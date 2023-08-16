<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Resources\PhotoDetailResource;
use App\Http\Resources\PhotoResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::when(Auth::user()->role !== "admin", function($query){
            $query->where("user_id", Auth::id());
        })->latest("id")->get();

        if(empty($photos->toArray())){
            return response()->json([
                "message" => "there is no photo"
            ]);
        }

        return PhotoResource::collection($photos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request)
    {
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            $savedPhotos = [];
            foreach ($photos as $photo) {
                $name = md5(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME));
                $savedPhoto = $photo->store("public/photo");
                $savedPhotos[] = [
                    "url" => $savedPhoto,
                    "name" => $name,
                    "ext" => $photo->extension(),
                    "user_id" => Auth::id(),
                    "created_at" => now(),
                    "updated_at" => now()

                ];
            }
            Photo::insert($savedPhotos);
        }

        return response()->json([
            "message" => "uploaded photo successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        if(is_null($photo)){
            return response()->json([
                "message" => "there is no photo"
            ]);
        }

        return new PhotoDetailResource($photo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        // return $request;
    }

    public function updateMultiplePhotos(Request $request)
    {
        // return $request;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
