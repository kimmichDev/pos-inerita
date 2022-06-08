<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillables = ['customer_name', 'voucher_number', 'date', 'total'];
    public function voucherList()
    {
        return $this->hasMany(VoucherList::class, 'voucher_id');
    }
}
