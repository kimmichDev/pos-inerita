<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherListResource;
use App\Http\Resources\VoucherResource;
use App\Models\DailySaleReport;
use App\Models\Item;
use App\Models\Voucher;
use App\Models\VoucherList;
use Carbon\Carbon;
use Inertia\Inertia;

class SaleController extends Controller
{
    public function showDailySaleReport()
    {
        $items = VoucherListResource::collection(VoucherList::whereDate("created_at", Carbon::today())->latest("id")->get());
        $totalItemQuantity = $items->groupBy("item_id")->map(function ($row) {
            return $row->sum("quantity");
        });
        $vouchers = VoucherResource::collection(Voucher::whereDate("created_at", Carbon::today())->latest()->get());

        return Inertia::render(
            "Sale/DailySaleReport",
            [
                "todaySales" => VoucherResource::collection(Voucher::whereDate("created_at", Carbon::today())->get()),
                "saleItems" => $items,
                "totalItemQuantity" => $totalItemQuantity,
                "itemNames" => Item::all(["id", "name"]),
                "vouchers" => $vouchers,
            ]
        );
    }

    public function storeDailySaleReport()
    {
        DailySaleReport::create([
            "daily_sale_report_date" => Carbon::now()->toDateTimeString(),
            "daily_sale_report_total" => Voucher::whereDate("created_at", Carbon::today())->get()->sum("total")
        ]);
        return Inertia::render("Dashboard");
    }
}
