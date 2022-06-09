<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DailySaleReport;
use App\Models\Item;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherList;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     "name" => "admin",
        //     "email" => "admin@gmail.com",
        //     "password" => Hash::make("swsxswsx")
        // ]);


        // $categories = ["Coffe based", "Tea based", "Kitchen's made"];
        // foreach ($categories as $c) {
        //     Category::create([
        //         "name" => $c,
        //     ]);
        // }


        // item
        // $datas = Http::get("https://api.openbrewerydb.org/breweries")->object();
        // for ($i = 0; $i < 10; $i++) {
        //     Item::create([
        //         "name" => $datas[$i]->name,
        //         "price" => rand(1000, 2000),
        //         "category_id" => Category::where("id", rand(1, 3))->first()->id,
        //     ]);
        // }
        // foreach ($datas as $d) {
        //     Item::create([
        //         "name" => $d->name,
        //         "price" => rand(1000, 2000),
        //         "category_id" => Category::where("id", rand(1, 3))->first()->id,
        //     ]);
        // }

        //daily sale report
        $period = CarbonPeriod::create('2022-06-6', '2022-06-8'); //period
        foreach ($period as $date) {
            $dsr = new DailySaleReport();
            $dsr->date = $date->format('Y-m-d');
            $dsr->total = 0;
            $dsr->save();
            $daily_sale_report_total = 0;

            $voucher_total = 0;
            for ($v = 1; $v < rand(1, 5); $v++) {
                $voucher = new Voucher();
                $voucher->customer_name = Str::random(rand(5, 10));
                $voucher->date = $date->format('Y-m-d');
                $voucher->voucher_number = "voucher-" . uniqid();
                $voucher->total = $voucher_total;
                $voucher->save();

                // voucherlist
                for ($vl = 1; $vl < rand(3, 5); $vl++) {
                    $item = Item::find(rand(1, 10));
                    $quantity = rand(1, 5);
                    $cost = $item->price * $quantity;
                    $voucher_total += $cost;
                    VoucherList::create([
                        "voucher_id" => $voucher->id,
                        "item_id" => $item->id,
                        "item_name" => $item->name,
                        "unit_price" => $item->price,
                        "quantity" => $quantity,
                        "cost" => $cost,
                        "date" => $date->format('Y-m-d')
                    ]);
                }
                $voucher->update(["total" => $voucher_total]);
                $daily_sale_report_total += $voucher_total;
            }
            $dsr->update(["total" => $daily_sale_report_total]);
        }
    }
}
