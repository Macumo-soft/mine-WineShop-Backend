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
     * Select wine list
     *
     * @param Request $request
     * @return void
     */
    public static function selectWineList(array $request): object
    {
        $result = Wine::select(
            'm_wine.id as id',
            'm_wine.name as name',
            'm_wine.img_url as imageUrl',
            DB::raw('Round(AVG(t_reviews.review_score), 1) as rate'),
            'm_wine.price as price',
        )
            ->join('m_wine_type', 'm_wine.wine_type_id', '=', 'm_wine_type.id')
            ->join('t_reviews', 'm_wine.id', '=', 't_reviews.wine_id')

        // Where condition
            ->when(!empty($request['wineTypeId']), function ($query) use ($request) {
                return $query->where('m_wine_type.id', '=', $request['wineTypeId']);
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
     * Select top 8 wines that filteredId condition
     *
     * @param Request $request
     * @return void
     */
    public static function selectFilteredWineList(array $request): object
    {
        // Store filterId value
        $filter_id = $request['filterId'];

        $result = Wine::select(
            'm_wine.id as id',
            'm_wine.name as name',
            'm_wine.img_url as imageUrl',
            DB::raw('Round(AVG(t_reviews.review_score), 1) as rate'),
            'm_wine.price as price',
        )
            ->join('m_wine_type', 'm_wine.wine_type_id', '=', 'm_wine_type.id')
            ->join('t_reviews', 'm_wine.id', '=', 't_reviews.wine_id')

            ->groupBy('m_wine.id')

        // Order by condition
        // filterId: 1 [Top rate] - Highest review rate
            ->when($filter_id == 1, function ($query) use ($request) {
                return $query->orderBy('rate', 'desc');
            })

        // filterId: 2 [Recommend] - Most reviews
            ->when($filter_id == 2, function ($query) use ($request) {
                return $query->orderByRaw('count(t_reviews.id)');
            })

        // filterId: 3 [Sale] - Cheapest price
            ->when($filter_id == 3, function ($query) use ($request) {
                return $query->orderBy('m_wine.price', 'asc');
            })

        // filterId: 4 [New] - Latest update date
            ->when($filter_id == 4, function ($query) use ($request) {
                return $query->orderby('m_wine.updated_at', 'desc');
            })
            ->orderBy('m_wine.id')
            ->limit(8)
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
            'm_wine.id as id',
            'm_wine.name as name',
            'm_wine.img_url as imageUrl',
            'm_wine.price as price',
            'm_wine_type.name as wineType',
            DB::raw('Round(AVG(t_reviews.review_score), 1) as rate'),
            'm_wine_detail.centilitre as centilitre',
            'm_wine_detail.description as description',
            'm_wine_detail.abv as abv',
            'm_wine_delivery.stocks as stocks',
            DB::raw('(current_date + delivery_period) as deliveryDateFrom'),
            DB::raw('(current_date + delivery_period + 3) as deliveryDateTo'),
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
                'm_wine_detail.description',
                'm_wine_delivery.stocks',
                'm_wine_delivery.delivery_period'
            )
            ->orderBy('m_wine.id')
            ->get();

        return $result;
    }
}
