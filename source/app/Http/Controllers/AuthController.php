<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Wine;
use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
            ];

            // Validation Check
            ValidationHandler::validate($request, $rules);

            // Check if value exist
            ValidationHandler::checkArrayValueExists($request);

            // Check if there is no unknown parameter key
            ValidationHandler::checkUnknownParameter($request, $rules);

            // Request parameters
            $request_params = $this->requestHandler($request, $rules);
            

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

    public function logout(Request $request){
        
    }

}
