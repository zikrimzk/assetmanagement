<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code',
        'asset_cost',
        'asset_marketval',
        'asset_brand',
        'asset_serialno',
        'asset_remarks',
        'asset_date',
        'asset_status',
        'asset_qrlink',
        'asset_image',
        'comp_id',
        'dep_id',
        'area_id',
        'item_id',
         'staff_id'
    ];
}
