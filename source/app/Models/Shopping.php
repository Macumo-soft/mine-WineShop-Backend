<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shopping extends Model
{
    // Table name
    protected $table = 't_carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'wine_id',
        'user_id',
        'created_at',
        'updated_at',
        'created_user',
        'updated_user',
        'delete_flg',
    ];

    public static function getCartList(Request $request)
    {

        $user = User::getUserFromPlainToken($request);

        $result = Shopping::select(
            't_carts.wine_id as wineId',
            't_carts.quantity as quantity',
        )->where('id', '=', $user['id']);

        // Return empty array if cartList data is empty
        if (empty($result)) {
            return [];
        }

        return $result;
    }

    public static function updateCartList(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        // Store array type JSON
        $wineOrderList = $request['wineList'];

        try {
            // Start DB transaction
            DB::beginTransaction();

            // Insert each order in wineList array
            foreach ($wineOrderList as $wineOrder) {

                // Upsert user's cart lista
                Shopping::updateOrCreate(
                    // First Argument: Looks for a matching record
                    [
                        'user_id' => $user['id'],
                        'delete_flg' => false,
                        'wine_id' => $wineOrder['wineId'],
                    ],
                    // Second Argument: Will be updated with this value if the records exists
                    [
                        'quantity' => $wineOrder['quantity'],
                        'updated_at' => DB::raw('NOW()'),
                        'created_user' => "mine_backend",
                        'updated_user' => "mine_backend",
                    ]
                    // If the record can not be found, a new record will be inserted with the merged attributes of both argument
                );
            }

            // Commit transaction
            DB::commit();

        } catch (\Throwable$th) {
            // Rollback transaction
            DB::rollback();

            // Return error
            throw new \Exception(
                $th->getMessage(),
                $th->getCode(),
            );
        }
    }

    public static function confirmOrder(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        // Store array type JSON
        $cart_list = Shopping::select(
            't_carts.id as cart_id',
        )
            ->where([
                ['t_carts.user_id', '=', $user['id']],
                ['t_carts.delete_flg', '=', false],
            ])->get();

        if (empty($cart_list)) {
            return;
        }

        try {
            // Start DB transaction
            DB::beginTransaction();

            // Insert each order in wineList array
            foreach ($cart_list as $cart_item) {

                Shopping::where('t_carts.id', $cart_item['cart_id'])
                    ->update(
                        [
                            't_carts.delete_flg' => true,
                            't_carts.updated_at' => DB::raw('NOW()'),
                            't_carts.updated_user' => $user['id'],
                        ]
                    );
            }

            // Commit transaction
            DB::commit();

        } catch (\Throwable$th) {
            // Rollback transaction
            DB::rollback();

            // Return error
            throw new \Exception(
                $th->getMessage(),
                $th->getCode(),
            );
        }
    }
}
