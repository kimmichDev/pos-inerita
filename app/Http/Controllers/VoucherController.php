<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use App\Models\VoucherList;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVoucherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoucherRequest $request)
    {
        DB::transaction(function () use ($request) {
            $voucher = new Voucher();
            $voucher->customer_name = $request->customerName;
            $voucher->voucher_number = $request->voucherNumber;
            $voucher->total = $request->total;
            $voucher->date = now()->format("Y-m-d");
            $voucher->save();

            foreach ($request->vouchers as $v) {
                $voucherList = new VoucherList();
                $voucherList->voucher_id = $voucher->id;
                $voucherList->item_id = $v["item"]["id"];
                $voucherList->item_name = $v["item"]["name"];
                $voucherList->unit_price = $v["item"]["price"];
                $voucherList->quantity = $v["quantity"];
                $voucherList->cost = $v["cost"];
                $voucherList->date = now()->format("Y-m-d");
                $voucherList->save();
            }
        });

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVoucherRequest  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
