<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
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

    public function updateCartList(Request $request)
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
            Shopping::updateCartList($request);

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
            $rules = [];

            // Validation Check
            ValidationHandler::default($request, $rules);
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
