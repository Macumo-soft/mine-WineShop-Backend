<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersDetail extends Model
{
    // Table name
    protected $table = 't_order_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'wine_id',
        'cart_id',
        'quantity',
        'order_id',
        'created_at',
        'updated_at',
        'created_user',
        'updated_user',
        'delete_flg',
    ];
}
