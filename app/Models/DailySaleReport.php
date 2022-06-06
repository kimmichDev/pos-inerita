<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySaleReport extends Model
{
    use HasFactory;
    protected $fillable = ["daily_sale_report_date", "daily_sale_report_total"];
}
