<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function VoucherRecord()
    {
        return $this->hasMany(VoucherRecord::class);
    }

    protected $fillable = ["customer", "phone", "voucher_number", "total", "tax", "net_total", "user_id"];
}
