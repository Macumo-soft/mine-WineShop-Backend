<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    // Table name
    protected $table = 't_reviews';

    /**
     * Select wine review information
     *
     * @param [type] $request_params
     * @return void
     */
    public static function selectWineReviews(array $request_params)
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

    public static function insertReview(array $request_params)
    {
        $result = Reviews::insert([
            'user_id' => '1', // Get user from token
            'wine_id' => $request_params['wineId'],
            'review_score' => $request_params['reviewScore'],
            'review_title' => $request_params['reviewTitle'],
            'review_comment' => $request_params['reviewComment'],
        ]);
    }
}
