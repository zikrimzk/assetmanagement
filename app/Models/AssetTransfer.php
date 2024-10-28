<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'trans_description',
        'trans_status',
        'trans_date',
        'new_dep',
        'new_area',
        'asset_id',
        'transferby',
        'approvedby'
    ];
}
