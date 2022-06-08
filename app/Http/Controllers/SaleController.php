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
        $items = VoucherListResource::collection(VoucherList::where("date", Carbon::today()->format("Y-m-d"))->latest("id")->get());
        $totalItem = $items->groupBy("item_id");
        $totalItemName = [];
        foreach ($totalItem as $key => $value) {
            array_push($totalItemName, $value[0]->item_name);
        }

        $totalItemQuantity = [];
        $totalItemCount = $items->groupBy("item_id")->map(fn ($row) => $row->sum("quantity"));
        foreach ($totalItemCount as $key => $value) {
            array_push($totalItemQuantity, $value);
        }

        $vouchers = VoucherResource::collection(Voucher::where("date", Carbon::today()->format('Y-m-d'))->latest()->get());

        $vl = VoucherList::where("date", Carbon::today()->format("Y-m-d"))->latest("id")->get()->groupBy("item_name")->map(fn ($row) => $row->sum("quantity"))->toArray();
        $topSeller = array_keys($vl, max($vl));

        return Inertia::render(
            "Sale/DailySaleReport",
            [
                "todaySales" => VoucherResource::collection(Voucher::where("date", Carbon::today()->format('Y-m-d'))->get()),
                "vouchers" => $vouchers,
                "totalItemQuantity" => $totalItemQuantity,
                "totalItemName" => $totalItemName,
                "topSeller" => $topSeller,
                "isClosed" => DailySaleReport::where("date", now()->format("Y-m-d"))->exists()
            ]
        );
    }

    public function storeDailySaleReport()
    {
        DailySaleReport::create([
            "date" => Carbon::now()->toDateString(),
            "total" => Voucher::whereDate("created_at", Carbon::today())->get()->sum("total")
        ]);
        return redirect()->back();
    }
}
