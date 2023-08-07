<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ["name", "company", "user_id" , "information" , "photo"];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
