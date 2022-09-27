<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use App\Request\Handler as RequestHandler;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_user',
        'updated_user',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function deleteUser(Request $request)
    {
        // Get user from token
        $user = User::getUserFromPlainToken($request);

        // Update user and set delete_flg
        $result = User::where('id', $user->id)
            ->where('delete_flg', false)
            ->limit(1)
            ->update(['delete_flg' => true]);

        return $result;
    }

    public static function getUserFromPlainToken(Request $request)
    {
        $plain_token = RequestHandler::getBearerToken($request);

        // Get user from plain token
        $token = PersonalAccessToken::findToken($plain_token);
        $user = $token->tokenable;

        // Return error if user can't be found
        if (empty($user)) {
            throw new \Exception(
                "Couldn't find any user from the token",
                config('response.status.bad_request.code')
            );
        };

        return $user;
    }

    public static function getUserFromHashedToken(Request $request)
    {
        $hashed_token = RequestHandler::getBearerToken($request);

        // Get user from hashedToken
        $token = PersonalAccessToken::where('token', $hashed_token)->first();
        $user = $token->tokenable;
        return $user;
    }

}
