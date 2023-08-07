<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = ["Ma Ma", "Yum Yum", "Shark", "Apple", "Dell"];
        $arr = [];
        foreach ($brands as $brand) {
            $arr[] = [
                "name" => $brand,
                "company" => $brand,
                "information" => "contact our company",
                "photo" => "There is no photo",
                // "user_id" => User::where("role","admin")->get()->random()->id,
                "user_id" => 1,
                "updated_at" => now(),
                "created_at" => now(),
            ];
        }
        Brand::insert($arr);
    }
}
