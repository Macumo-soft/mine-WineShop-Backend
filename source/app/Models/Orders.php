<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Orders extends Model
{
    // Table name
    protected $table = 't_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'delivery_date',
        'created_at',
        'updated_at',
        'created_user',
        'updated_user',
        'delete_flg',
    ];
}
