<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VoucherController;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\VoucherList;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', [SaleController::class, 'dashboardHandle'])->name('dashboard');

    Route::resource("/category", CategoryController::class);

    Route::resource("/item", ItemController::class);

    Route::get("/", fn () => Inertia::render("Pos/Pos", ["items" => ItemResource::collection(Item::latest('id')->get()), "categories" => Category::all()]))->name('pos')->middleware("dailySaleReport");

    Route::resource("/voucher", VoucherController::class);

    Route::get("/daily-sale-report", [SaleController::class, 'showDailySaleReport'])->name("dailySaleReport");
    Route::post("/daily-sale-report", [SaleController::class, 'storeDailySaleReport'])->name("dailySaleReport.store");

    Route::get("/daily-voucher-pdf", [SaleController::class, 'dailyVoucherPdf'])->name("dailyVoucher.pdf");
    Route::get("/dashbaord-daily-voucher-pdf", [SaleController::class, 'dashboardDailyVoucherPdf'])->name("dashboardDailyVoucher.pdf");
});


Route::get("/test", function () {
    return VoucherList::whereMonth("date", Carbon::parse("2022-05-11")->format('m'))->get();
});
