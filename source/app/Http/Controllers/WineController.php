<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Wine;
use App\Validations\Handler as ValidationHandler;
use App\Response\Handler as ResponseHandler;
use DB;
use Illuminate\Http\Request;
use Validator;

class WineController extends Controller
{
    public function getWineList(Request $request)
    {
        try {
            $request_param = array(
                'filterId' => $request['filterId'],
                'wineType' => $request['wineTypeId'],
                'wineName' => $request['wineName'],
                'customersReview' => $request['customersReview'],
                'priceFrom' => $request['priceFrom'],
                'priceTo' => $request['priceTo'],
            );

            // Validaton
            if (empty($request_param) || isset($request_param)) {
                throw new Exception("Error Processing Request", 1);

                return $request_param;
            }

            $filterId = $request['filterId'];
            $wineType = $request['wineTypeId'];
            $wineName = $request['wineName'];
            $customersReview = $request['customersReview'];
            $priceFrom = $request['priceFrom'];
            $priceTo = $request['priceTo'];

            return $request;

            // Search by Wine Name
            $wineResult = Wine::select(
                'm_wine.id as wineId',
                'm_wine.name as wineName',
                'm_wine.img_url as wineImageUrl',
                DB::raw('AVG(t_reviews.review_score) as reviewAverage'),
            )
                ->join('t_reviews', 'm_wine.id', '=', 't_reviews.wine_id')
                ->where('m_wine.id', '=', $wineType)
                ->groupBy('m_wine.id')
                ->orderBy('m_wine.id')
                ->get();

            return $wineResult;

        } catch (\Throwable$th) {
            //throw $th;
            return $th;
            return ApiResponser::response($statusCode = 400, $message = "test error");
        }

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
            $wineDetail = Wine::getWineDetail($request_params);

            // Get review list by wineId
            $reviewList = Reviews::getWineReviews($request_params);

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
        logger('test', ['foo' => 'bar']);
        // Return success
        return ResponseHandler::success($response);
    }
}
