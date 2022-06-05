<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    public function showDailySaleReport()
    {
        return Inertia::render(
            "Sale/DailySaleReport",
            ["todaySales" => VoucherResource::collection(Voucher::whereDate("created_at", Carbon::today())->get())]
        );
    }
}
