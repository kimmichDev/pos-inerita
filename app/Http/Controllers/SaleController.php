<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherListResource;
use App\Http\Resources\VoucherResource;
use App\Models\DailySaleReport;
use App\Models\Item;
use App\Models\Voucher;
use App\Models\VoucherList;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $voucherLists = VoucherListResource::collection(VoucherList::where("date", $date)->paginate()->withQueryString());
        // $dsr = DailySaleReport::whereMonth("date",Carbon::parse(request('month'))->format('Y-m-d');)

        $vl = VoucherList::where("date", $date)->latest("id")->get()->groupBy("item_name")->map(fn ($row) => $row->sum("quantity"))->toArray();
        // return array_keys($vl, 2);
        count($vl) > 0 ? $topSeller = array_keys($vl, max($vl)) : $topSeller = ["no item"];
        // $topSeller = ["u$tnavilable"];

        return Inertia::render(
            "Sale/DailySaleReport",
            [
                "todaySales" => VoucherResource::collection(Voucher::where("date", $date)->get()),
                "voucherLists" => $voucherLists,
                "totalItemQuantity" => $totalItemQuantity,
                "totalItemName" => $totalItemName,
                "topSeller" => $topSeller,
                "isClosed" => DailySaleReport::where("date", $date)->exists(),
                "selectedDate" => Carbon::parse(request('date'))->format('d-M-Y')
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

    public function dailyVoucherPdf()
    {
        $date = Carbon::parse(request('date'))->format('Y-m-d');
        $voucherLists = VoucherListResource::collection(VoucherList::where("date", $date)->get());
        $total = $voucherLists->sum('cost');
        $pdf = Pdf::loadView("pdf.daily-voucher", ["voucherLists" => $voucherLists, "total" => $total]);
        return $pdf->download(Carbon::parse(request('date'))->format('d-M-Y') . "-daily-voucher.pdf");
    }

    public function dashboardHandle()
    {
        $vl = VoucherList::where("date", now()->format('Y-m-d'))->latest("id")->get()->groupBy("item_id")->map(fn ($row) => $row->sum("quantity"))->toArray();
        if (count($vl) > 0) {
            $topSellerItemId = array_keys($vl, max($vl))[0];
            $topSellerItemToday = Item::where("id", $topSellerItemId)->get()->map(fn ($item) => [
                "name" => $item->name,
                "photo" => asset("storage/item-photo/" . $item->photo),
                "price" => $item->price
            ]);
        } else {
            $topSellerItemToday = "No item";
        };

        $voucherListMonthly = VoucherList::whereMonth("date", now()->format('m'))->latest("id")->get()->groupBy("item_id")->map(fn ($row) => $row->sum("quantity"))->toArray();
        if (count($voucherListMonthly) > 0) {
            $topSellerItemId = array_keys($voucherListMonthly, max($voucherListMonthly))[0];
            $topSellerThisMonth = Item::where("id", $topSellerItemId)->get()->map(fn ($item) => [
                "name" => $item->name,
                "photo" => asset("storage/item-photo/" . $item->photo),
                "price" => $item->price
            ]);
        } else {
            $topSellerThisMonth = "No item";
        };

        $totalVl = VoucherList::whereMonth("date", now()->format('m'))->get();
        count($totalVl) > 0 ?   $totalSaleAmount = $totalVl->sum('cost') : $totalSaleAmount = "No data";
        count($totalVl) > 0 ?  $totalSaleQuantity = $totalVl->sum('quantity') : $totalSaleQuantity = "No data";
        return Inertia::render('Dashboard', [
            "topSellerItemToday" => $topSellerItemToday,
            "topSellerThisMonth" => $topSellerThisMonth,
            "totalSaleAmount" => $totalSaleAmount,
            "totalSaleQuantity" => $totalSaleQuantity
        ]);
    }
}
