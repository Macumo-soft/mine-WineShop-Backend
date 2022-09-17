<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Wine;
use App\Response\Handler as ResponseHandler;
use App\Validations\Handler as ValidationHandler;
use Illuminate\Http\Request;

class WineController extends Controller
{
    public function getWineList(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'filterId' => 'digits:1',
                'wineType' => 'digits:2',
                'wineName' => 'string',
                'customersReview' => 'string',
                'priceFrom' => 'digits_between:1,3',
                'priceTo' => 'digits_between:1,3',
            ];

            // Validation Check
            ValidationHandler::validate($request, $rules);

            // Check if value exist
            ValidationHandler::checkArrayValueExists($request);

            // Check if there is no unknown parameter key
            ValidationHandler::checkUnknownParameter($request, $rules);

            // Request parameters
            $request_params = $this->requestHandler($request, $rules);
            
            if (!empty($request_params['filterId'])) {
                // Search wine list by filterId condition
                $response['wineList'] = Wine::selectFilteredWineList($request_params);

            } else {
                // Search wines with other request parameters given
                $response['wineList'] = Wine::selectWineList($request_params);
            }

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

    public function getWineDetail(Request $request)
    {
        // Response
        $response = [];

        try {
            // Define validation rules
            $rules = [
                'wineId' => 'required',
            ];

            // Validation Check
            ValidationHandler::validate($request, $rules);

            // Request parameters
            $request_params = $this->requestHandler($request, $rules);

            // Get wine details information by wineId
            $wineDetail = Wine::selectWineDetail($request_params);

            // Get review list by wineId
            $reviewList = Reviews::selectWineReviews($request_params);

            // Store values into response parameters
            $response['wineDetailList'] = $wineDetail;
            $response['reviewList'] = $reviewList;

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
