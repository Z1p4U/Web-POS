<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    use HasFactory;

    protected $fillable = ['total_voucher', 'total_actual_price',  'total_cash', 'tax_total', 'total'];
}
