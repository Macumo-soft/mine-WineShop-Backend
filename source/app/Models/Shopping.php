<?php

namespace App\Models;

use App\Models\Orders;
use App\Models\OrdersDetail;
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
            't_carts.id as cartId',
            't_carts.wine_id as wineId',
            't_carts.quantity as quantity',
            'm_wine.name as name',
            'm_wine.img_url as imageUrl',
            'm_wine.price as price',
            DB::raw('(current_date + delivery_period) as deliveryFrom'),
            DB::raw('(current_date + delivery_period + 3) as deliveryTo'),
        )
            ->join('m_wine', 'm_wine.id', '=', 't_carts.wine_id')
            ->join('m_wine_delivery', 'm_wine.id', '=', 'm_wine_delivery.wine_id')

            ->where([
                ['t_carts.user_id', '=', $user['id']],
                ['t_carts.delete_flg', '=', false],
            ])->get();

        // convert Object data to array
        $result = json_decode(json_encode($result), true);
        if (empty($result)) {
            // Return empty array if cartList data is empty
            return [];
        }

        return $result;
    }

    public static function addItem(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        // Store array type JSON
        $wineId = $request['wineId'];

        try {
            // Start DB transaction
            DB::beginTransaction();

            // 1. Get current cart list
            $cart_list = Shopping::select(
                't_carts.id as cart_id',
                't_carts.wine_id as wine_id',
                't_carts.quantity as quantity',
            )
                ->where([
                    ['t_carts.user_id', '=', $user['id']],
                    ['t_carts.wine_id', '=', $wineId],
                    ['t_carts.delete_flg', '=', false],
                ])->get();

            // convert Object data to array
            $cart_list = json_decode(json_encode($cart_list), true);

            // 2. If same item doesn't exist, add item
            if (empty($cart_list)) {
                Shopping::create([
                    'user_id' => $user['id'],
                    'wine_id' => $wineId['wineId'],
                    'quantity' => 1, // Add 1 Item
                    'created_user' => 'mine_backend',
                    'updated_user' => 'mine_backend',
                ]);

            } else {
                // Throw an exception, if 2 or more same item exists
                if (count($cart_list) >= 2) {
                    throw new \Exception(
                        __('message.message.Unexcepted'),
                        config('response.status.internal_server_error.code')
                    );
                }

                // 3. If same item exists, add quantity
                $current_quantity = $cart_list[0]['quantity'];
                // Add 1 item to current quantity
                $current_quantity += 1;

                Shopping::where([
                    ['t_carts.id', '=', $cart_list[0]['cart_id']],
                    ['t_carts.user_id', '=', $user['id']],
                    ['t_carts.delete_flg', '=', false],
                ])
                    ->update(
                        [
                            't_carts.quantity' => $current_quantity,
                            't_carts.updated_at' => DB::raw('NOW()'),
                            't_carts.updated_user' => 'mine_backend',
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

    public static function updateItem(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        // Store array type JSON
        $wineOrderList = $request['wineList'];

        try {
            // Start DB transaction
            DB::beginTransaction();

            // 1. Get current cart list
            $cart_list = Shopping::select(
                't_carts.id as cart_id',
                't_carts.wine_id as wine_id',
                't_carts.quantity as quantity',
            )
                ->where([
                    ['t_carts.user_id', '=', $user['id']],
                    ['t_carts.wine_id', '=', $wineOrderList['wineId']],
                    ['t_carts.delete_flg', '=', false],
                ])->get();

            // convert Object data to array
            $cart_list = json_decode(json_encode($cart_list), true);

            // 2. If same item doesn't exist, add item
            if (empty($cart_list)) {
                // return 1;
                Shopping::create([
                    'user_id' => $user['id'],
                    'wine_id' => $wineOrderList['wineId'],
                    'quantity' => $wineOrderList['quantity'],
                    'created_user' => 'mine_backend',
                    'updated_user' => 'mine_backend',
                ]);

            } else {
                // Throw an exception, if 2 or more same item exists
                if (count($cart_list) >= 2) {
                    throw new \Exception(
                        __('message.message.Unexcepted'),
                        config('response.status.internal_server_error.code')
                    );
                }

                // 3. If same item exists, update quantity
                Shopping::where([
                    ['t_carts.id', '=', $cart_list[0]['cart_id']],
                    ['t_carts.user_id', '=', $user['id']],
                    ['t_carts.delete_flg', '=', false],
                ])
                    ->update(
                        [
                            't_carts.quantity' => $wineOrderList['quantity'],
                            't_carts.updated_at' => DB::raw('NOW()'),
                            't_carts.updated_user' => 'mine_backend',
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

    public static function deleteItem(Request $request)
    {
        $user = User::getUserFromPlainToken($request);

        try {
            // Start DB transaction
            DB::beginTransaction();

            Shopping::where([
                ['t_carts.id', '=', $request['cartId']],
                ['t_carts.user_id', '=', $user['id']],
                ['t_carts.delete_flg', '=', false],
            ])
                ->update(
                    [
                        't_carts.delete_flg' => true,
                        't_carts.updated_at' => DB::raw('NOW()'),
                        't_carts.updated_user' => 'mine_backend',
                    ]
                );

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

        $order_list = $request['orderList'];

        if (empty($order_list)) {
            return;
        }

        try {
            // Start DB transaction
            DB::beginTransaction();

            // Get latest delivery date
            $delivery_date = '2022-12-01';

            $order_insert_result = Orders::create([
                'user_id' => $user['id'],
                'delivery_date' => $delivery_date,
                'created_user' => 'mine_backend',
                'updated_user' => 'mine_backend',
            ]);

            // Insert each order in wineList array
            foreach ($order_list as $order_item) {

                OrdersDetail::create([
                    'wine_id' => $order_item['wineId'],
                    'cart_id' => $order_item['cartId'],
                    'quantity' => $order_item['quantity'],
                    'order_id' => $order_insert_result['id'],
                    'created_user' => 'mine_backend',
                    'updated_user' => 'mine_backend',
                ]);

                // Logically delete cart list data
                Shopping::where('t_carts.id', $order_item['cartId'])
                    ->update(
                        [
                            't_carts.delete_flg' => true,
                            't_carts.updated_at' => DB::raw('NOW()'),
                            't_carts.updated_user' => 'mine_backend',
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
