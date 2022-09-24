<?php

namespace App\Http\Controllers;

use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;
use App\Models\Reviews;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                // 'token' => 'required|string',
                'wineId' => 'required',
                'reviewScore' => 'required|digits:1',
                'reviewTitle' => 'max:60',
                'reviewComment' => 'string:65535',
            ];

            // Validation Check
            ValidationHandler::validate($request, $rules);

            // Check if there is no unknown parameter key
            ValidationHandler::checkUnknownParameter($request, $rules);

            // Request parameters
            $request_params = $this->requestHandler($request, $rules);

            $response = $request_params;

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

    public function updateReview(Request $request)
    {
        return 'success';
    }

    public function deleteReview(Request $request)
    {

    }

}
