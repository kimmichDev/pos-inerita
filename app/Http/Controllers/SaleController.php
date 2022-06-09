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
        // return request();
        $date = Carbon::parse(request('date'))->format('Y-m-d');
        // return $date;
        $items = VoucherListResource::collection(VoucherList::where("date", $date)->latest("id")->get());
        // return $items;
        $totalItem = $items->groupBy("item_id");
        $totalItemName = [];
        foreach ($totalItem as $key => $value) {
            array_push($totalItemName, $value[0]->item_name);
        }

        $totalItemQuantity = [];
        $totalItemCount = $items->groupBy("item_id")->map(fn ($row) => $row->sum("quantity"));
        // return $totalItemCount;
        foreach ($totalItemCount as $key => $value) {
            array_push($totalItemQuantity, $value);
        }

        $vouchers = VoucherResource::collection(Voucher::where("date", $date)->latest()->get());

        $vl = VoucherList::where("date", $date)->latest("id")->get()->groupBy("item_name")->map(fn ($row) => $row->sum("quantity"))->toArray();
        count($vl) > 0 ? $topSeller = array_keys($vl, max($vl)) : $topSeller = ["no item"];
        // $topSeller = ["u$tnavilable"];

        return Inertia::render(
            "Sale/DailySaleReport",
            [
                "todaySales" => VoucherResource::collection(Voucher::where("date", $date)->get()),
                "vouchers" => $vouchers,
                "totalItemQuantity" => $totalItemQuantity,
                "totalItemName" => $totalItemName,
                "topSeller" => $topSeller,
                "isClosed" => DailySaleReport::where("date", $date)->exists(),
                "selectedDate" => $date
            ]
        );
    }

    public function storeDailySaleReport()
    {
        $date = Carbon::parse(request('date'))->format('Y-m-d');
        DailySaleReport::create([
            "date" => $date,
            "total" => Voucher::where("date", $date)->get()->sum("total")
        ]);
        return redirect()->back();
    }
}
