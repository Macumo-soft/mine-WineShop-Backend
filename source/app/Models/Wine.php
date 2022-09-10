<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class Wine extends Model
{
    // use HasFactory;
    // Table name
    protected $table = 'm_wine';

    public static function getWineDetail($request_params)
    {
        $result = Wine::select(
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
