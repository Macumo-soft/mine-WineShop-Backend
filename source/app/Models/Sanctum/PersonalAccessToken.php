<?php

namespace App\Models\Sanctum;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'token_expires_at' => 'datetime',
        'abilities' => 'json',
        'last_used_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'token_expires_at',
        'abilities',
    ];

    /**
     * アクセストークンの有効性を独自チェックする
     *
     * @param mixed $accessToken
     * @param bool $isValid
     * @return bool
     */
    public static function isValidAccessToken($accessToken, bool $isValid)
    {
        if (!$accessToken->token_expires_at) {
            return $isValid;
        }
        return $accessToken->token_expires_at->gt(now());
    }
}