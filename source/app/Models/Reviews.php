<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reviews extends Model
{
    // Table name
    protected $table = 't_reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'review_score',
        'review_title',
        'review_comment',
        'user_id',
        'wine_id',
        'created_at',
        'updated_at',
        'created_user',
        'updated_user',
        'delete_flg',
    ];

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
            'users.name as username',
            't_reviews.id as id',
            't_reviews.review_score as score',
            't_reviews.review_title as title',
            't_reviews.review_comment as comment',
            't_reviews.updated_at as updatedDate',
            DB::raw('t_reviews.created_at <> t_reviews.updated_at as edited'),
        )
            ->join('users', 't_reviews.user_id', '=', 'users.id')
            ->where([
                ['t_reviews.wine_id', '=', $request_params['wineId']],
                ['t_reviews.delete_flg', '=', false],
            ])
            ->get();

        return $result;
    }

    public static function createReview(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        try {
            // Start DB transaction
            DB::beginTransaction();

            $result = Reviews::create([
                'review_score' => $request['reviewScore'],
                'review_title' => $request['reviewTitle'],
                'review_comment' => $request['reviewComment'],
                'user_id' => $user['id'], // Get user from token
                'wine_id' => $request['wineId'],
                'created_user' => $user['id'],
                'updated_user' => $user['id'],
            ]);

            // Commit transaction
            DB::commit();

        } catch (\Throwable$th) {
            // Rollback transaction
            DB::rollback();

            // Return error
            throw new \Exception(
                $th->getMessage(),
                $th->getCode(),
            );
        }
    }

    public static function updateReview(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        try {
            // Start DB transaction
            DB::beginTransaction();

            Reviews::where([
                ['t_reviews.id', '=', $request['reviewId']],
                ['t_reviews.delete_flg', '=', false],
            ])
                ->update(
                    ['t_reviews.review_score' => $request['reviewScore'],
                        't_reviews.review_title' => $request['reviewTitle'],
                        't_reviews.review_comment' => $request['reviewComment'],
                        't_reviews.updated_at' => DB::raw('NOW()'),
                        't_reviews.updated_user' => $user['id'],
                    ]
                );

            // Commit transaction
            DB::commit();

        } catch (\Throwable$th) {
            // Rollback transaction
            DB::rollback();

            // Return error
            throw new \Exception(
                $th->getMessage(),
                $th->getCode(),
            );
        }
    }

    public static function deleteReview(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        try {
            // Start DB transaction
            DB::beginTransaction();

            Reviews::where([
                ['t_reviews.id', '=', $request['reviewId']],
                ['t_reviews.delete_flg', '=', false],
            ])
                ->update(
                    [
                        't_reviews.delete_flg' => true,
                        't_reviews.updated_at' => DB::raw('NOW()'),
                        't_reviews.updated_user' => $user['id'],
                    ]
                );

            // Commit transaction
            DB::commit();

        } catch (\Throwable$th) {
            // Rollback transaction
            DB::rollback();

            // Return error
            throw new \Exception(
                $th->getMessage(),
                $th->getCode(),
            );
        }
    }
}
