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

    public function showMonthlySaleReport()
    {
        $month = Carbon::parse(request('month'))->format('m');
        $thisMonthSale = VoucherResource::collection(Voucher::whereMonth("date", $month)->get())->groupBy('date')->map(fn ($sale) => $sale->sum('total'));

        $thisMonthSaleMonth = array_keys($thisMonthSale->toArray());
        $thisMonthSaleTotal = array_values($thisMonthSale->toArray());
        $items = VoucherListResource::collection(VoucherList::whereMonth("date", $month)->latest("id")->get());
        // return $items;
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

        $voucherLists = VoucherListResource::collection(VoucherList::whereMonth("date", $month)->paginate()->withQueryString());

        $vl = VoucherList::whereMonth("date", $month)->latest("id")->get()->groupBy("item_name")->map(fn ($row) => $row->sum("quantity"))->toArray();
        count($vl) > 0 ? $topSeller = array_keys($vl, max($vl)) : $topSeller = ["no item"];

        return Inertia::render(
            "Sale/MonthlySaleReport",
            [
                "thisMonthSaleMonth" => $thisMonthSaleMonth,
                "thisMonthSaleTotal" => $thisMonthSaleTotal,
                "voucherLists" => $voucherLists,
                "totalItemQuantity" => $totalItemQuantity,
                "totalItemName" => $totalItemName,
                "topSeller" => $topSeller,
                "selectedMonth" => Carbon::parse(request('month'))->format('M-Y')
            ]
        );
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

        $dailyVoucherDate = Carbon::parse(request('dvd'))->format('Y-m-d');
        $dailyVouchers = VoucherResource::collection(Voucher::where('date', $dailyVoucherDate)->latest('id')->paginate()->withQueryString());
        $dailyVoucherNumber = Voucher::where('date', $dailyVoucherDate)->latest('id')->pluck("voucher_number");
        $dailyVoucherTotal = Voucher::where('date', $dailyVoucherDate)->latest('id')->pluck("total");


        $monthlyDsrDate = Carbon::parse(request("month"))->format('m');
        $dsrs = DailySaleReport::whereMonth("date", $monthlyDsrDate)->latest('date')->paginate(10)->through(fn ($dsr) => [
            "date" => Carbon::parse($dsr->date)->format('d-M-Y'),
            "total" => $dsr->total
        ]);
        $dsrDate = DailySaleReport::whereMonth("date", $monthlyDsrDate)->latest('date')->pluck('date');
        $dsrTotal = DailySaleReport::whereMonth("date", $monthlyDsrDate)->latest('date')->pluck('total');
        return Inertia::render('Dashboard', [
            "topSellerItemToday" => $topSellerItemToday,
            "topSellerThisMonth" => $topSellerThisMonth,
            "totalSaleAmount" => $totalSaleAmount,
            "totalSaleQuantity" => $totalSaleQuantity,
            "dailyVouchers" => $dailyVouchers,
            "dailyVoucherNumber" => $dailyVoucherNumber,
            "dailyVoucherTotal" => $dailyVoucherTotal,
            "dailySaleReports" => $dsrs,
            "dailySaleReportDate" => $dsrDate,
            "dailySaleReportTotal" => $dsrTotal,
            "selectedDate" => Carbon::parse(request('dvd'))->format('d-M-Y'),
            "selectedMonth" => Carbon::parse(request('month'))->format('M-Y')
        ]);
    }

    public function dashboardDailyVoucherPdf()
    {
        $date = Carbon::parse(request('date'))->format('Y-m-d');
        $dailyVouchers = VoucherResource::collection(Voucher::where('date', $date)->latest('id')->get());
        $pdf = Pdf::loadView("pdf.dashboardDaily-voucher", ["dailyVouchers" => $dailyVouchers]);
        return $pdf->download(Carbon::parse(request('date'))->format('d-M-Y') . "-daily-voucher.pdf");
    }
}
