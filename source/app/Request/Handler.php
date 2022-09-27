<?php

namespace App\Request;

use Illuminate\Http\Request;

class Handler
{
    public static function getBearerToken(Request $request)
    {
        // Get Authorization value from header
        $header = $request->header('Authorization');

        // Eliminate portion of the string
        // eg. "Bearer 1|xxxxx" => "1|xxxxx"
        $bearer_token = substr($header, 7);

        if (empty($bearer_token)) {
            throw new \Exception(
                'Token could not found in authorization header',
                '401', // Bad request
            );
        }

        return $bearer_token;
    }
}
