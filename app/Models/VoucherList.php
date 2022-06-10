<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherList extends Model
{
    use HasFactory;
    protected $perPage = 10;
    protected $fillable = [
        "voucher_id", "item_id", "unit_price", "quantity", "cost", "date"
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, "item_id");
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
