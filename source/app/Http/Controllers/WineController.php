<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Wine;
use DB;
use Illuminate\Http\Request;

class WineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = DB::table('users')->get();

        //
        return "hello";

    }

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
            return ApiResponser::error($statusCode = 400, $message = "test error");
        }

    }

    public function getWineDetail(Request $request)
    {
        // Request
        $wineId = $request['wineId'];

        // Response
        $response = [];

        try {
            $wineResult = Wine::select(
                'm_wine.id as wineId',
                'm_wine.name as wineName',
                'm_wine.img_url as wineImageUrl',
                'm_wine_type.name as wineType',
                DB::raw('AVG(t_reviews.review_score) as reviewAverage'),
                'm_wine_detail.centilitre as centilitre',
                'm_wine_detail.abv as abv',
                'm_wine_delivery.stocks as stocks',
                'm_wine_delivery.delivery_period as deliveryPeriod',
            )
                ->join('m_wine_type', 'm_wine.wine_type_id', '=', 'm_wine_type.id')
                ->join('m_wine_detail', 'm_wine.id', '=', 'm_wine_detail.wine_id')
                ->join('t_reviews', 'm_wine.id', '=', 't_reviews.wine_id')
                ->join('m_wine_delivery', 'm_wine.id', '=', 'm_wine_delivery.wine_id')
                ->where('m_wine.id', '=', $wineId)
                ->groupBy(
                    'm_wine.id',
                    'm_wine_type.name',
                    'm_wine_detail.centilitre',
                    'm_wine_detail.abv',
                    'm_wine_delivery.stocks',
                    'm_wine_delivery.delivery_period'
                )
                ->orderBy('m_wine.id')
                ->get();

            $reviewResult = Reviews::select(
                't_reviews.user_id as userId',
                't_reviews.review_score as score',
                't_reviews.review_title as title',
                't_reviews.review_comment as comment',
                't_reviews.updated_at as updateDate',
            )
                ->where('t_reviews.wine_id', '=', $wineId)
                ->get();

            $response['wineDetailList'] = $wineResult;
            $response['reviewList'] = $reviewResult;

        } catch (\Throwable$th) {
            //throw $th;
        }

        return $response;

    }
}

/**
 * statusCode: string
 *  public statusCode?: StatusCode;
 *   public validationMessage?: { [key: string]: any };
 *   public data?: { [key: string]: any};
 *   public responseMessage?: string;
 *
 * export enum StatusCode{
// Successful Response
success = '200',

// Redirection messages
multipleChoices = '300',
movedPermanently = '301',

// Client error responses
badRequest = '400',
unauthorized = '401',
forbidden = '403',
notFound = '404',
methodNotAllowed = '405',
requestTimeout = '408',

// Server error responses
internalServerError = '500',
notImplemented = '501',
badGateway = '502',
serviceUnavailable = '503',
}
 */
