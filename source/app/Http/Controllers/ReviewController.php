<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'wineId' => 'required',
                'reviewScore' => 'required|digits:1',
                'reviewTitle' => 'max:60',
                'reviewComment' => 'string:65535',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Check if there is no unknown parameter key
            ValidationHandler::checkArrayValueExists($request);

            Reviews::createReview($request);

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
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'reviewId' => 'required',
                'reviewScore' => 'required|digits:1',
                'reviewTitle' => 'max:60',
                'reviewComment' => 'string:65535',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Check if there is no unknown parameter key
            ValidationHandler::checkArrayValueExists($request);

            Reviews::updateReview($request);

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

    public function deleteReview(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'reviewId' => 'required',
            ];

            // Validation Check
            ValidationHandler::default($request, $rules);

            // Check if there is no unknown parameter key
            ValidationHandler::checkArrayValueExists($request);

            Reviews::deleteReview($request);

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
