<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    /**
     * Get cart list
     *
     * @param Request $request
     * @return void
     */
    public function getCartList(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [];

            // Validation Check
            ValidationHandler::default($request, $rules);

            $response['wineList'] = Shopping::getCartList($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response);
    }

    /**
     * Add wine item to user's add item
     *
     * @param Request $request
     * @return void
     */
    public function addItem(Request $request)
    {

        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'wineId' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);
            
            // Check if value exist
            ValidationHandler::checkArrayValueExists($request);

            // update cart data
            return Shopping::addItem($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response);
    }

    /**
     * Update wine item in user's cart list
     *
     * @param Request $request
     * @return void
     */
    public function updateItem(Request $request)
    {

        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'wineList' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);
            
            // Check if value exist
            ValidationHandler::checkArrayValueExists($request);

            // update cart data
            Shopping::updateItem($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response);
    }

    /**
     * Delete wine item from user's cart list
     *
     * @param Request $request
     * @return void
     */
    public function deleteItem(Request $request)
    {

        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'cartId' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);
            
            // Check if value exist
            ValidationHandler::checkArrayValueExists($request);

            // update cart data
            Shopping::deleteItem($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response);
    }

    public function confirmOrder(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'orderList' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);
            
            // Confirm ordered data
            Shopping::confirmOrder($request);

        } catch (\Throwable$th) {
            // Return error
            return ResponseHandler::error(
                $th->getCode(),
                $th->getMessage()
            );
        }

        // Return success
        return ResponseHandler::success($response);

    }

}
