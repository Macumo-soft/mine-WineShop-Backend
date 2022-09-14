<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Wine extends Model
{
    // use HasFactory;
    // Table name
    protected $table = 'm_wine';

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public static function selectWineList(array $request): object
    {
        $result = Wine::select(
            'm_wine.id as wineId',
            'm_wine.name as wineName',
            'm_wine.img_url as wineImageUrl',
            DB::raw('Round(AVG(t_reviews.review_score), 1) as review'),
            'm_wine.price as winePrice',
        )
            ->join('m_wine_type', 'm_wine.wine_type_id', '=', 'm_wine_type.id')
            ->join('t_reviews', 'm_wine.id', '=', 't_reviews.wine_id')

        // Where condition
            ->when(!empty($request['wineType']), function ($query) use ($request) {
                return $query->where('m_wine_type.id', '=', $request['wineType']);
            })

            ->when(!empty($request['wineName']), function ($query) use ($request) {
                return $query->where('m_wine.name', '=', $request['wineName']);
            })

        // Both priceFrom and priceTo exists
            ->when(!empty($request['priceFrom']) && !empty($request['priceTo']), function ($query) use ($request) {
                return $query->whereBetween('m_wine.price', [$request['priceFrom'], $request['priceTo']]);
            })

        // Only priceFrom exists
            ->when(!empty($request['priceFrom']) && empty($request['priceTo']), function ($query) use ($request) {
                return $query->where('m_wine.price', '>=', $request['priceFrom']);
            })
            ->groupBy('m_wine.id')
            ->when(!empty($request['customersReview']), function ($query) use ($request) {
                return $query->havingRaw('Round(AVG(t_reviews.review_score), 1) = ?', [$request['customersReview']]);
            })
            ->orderBy('m_wine.id')
            ->get();

        return $result;
    }

    /**
     * Select wine details information
     *
     * @param array $request_params
     * @return object
     */
    public static function selectWineDetail(array $request_params): object
    {
        $result = Wine::select(
            'm_wine.id as wineId',
            'm_wine.name as wineName',
            'm_wine.img_url as wineImageUrl',
            'm_wine_type.name as wineType',
            DB::raw('Round(AVG(t_reviews.review_score), 1) as reviewAverage'),
            'm_wine_detail.centilitre as centilitre',
            'm_wine_detail.abv as abv',
            'm_wine_delivery.stocks as stocks',
            'm_wine_delivery.delivery_period as deliveryPeriod',
        )
            ->join('m_wine_type', 'm_wine.wine_type_id', '=', 'm_wine_type.id')
            ->join('m_wine_detail', 'm_wine.id', '=', 'm_wine_detail.wine_id')
            ->join('t_reviews', 'm_wine.id', '=', 't_reviews.wine_id')
            ->join('m_wine_delivery', 'm_wine.id', '=', 'm_wine_delivery.wine_id')
            ->where('m_wine.id', '=', $request_params['wineId'])
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

        return $result;
    }
}
