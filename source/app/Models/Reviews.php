<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class Reviews extends Model
{
    // use HasFactory;
    // Table name
    protected $table = 't_reviews';

    public static function getWineReviews($request_params)
    {
        $result = Reviews::select(
            't_reviews.wine_id as wineId',
            't_reviews.user_id as userId',
            't_reviews.review_score as score',
            't_reviews.review_title as title',
            't_reviews.review_comment as comment',
            't_reviews.updated_at as updateDate',
        )
            ->where('t_reviews.wine_id', '=', $request_params['wineId'])
            ->get();

        return $result;
    }
}
