<?php

namespace App\Validations;

use Validator;

class Handler
{
    private $default_message = [];

    public function __construct()
    {
        $default_message = __('validation');
    }

    public static function validate($request, $rules = [], $message = []) : void
    {
        // Load message in validation.php, if $message variable is empty
        if(empty($message)){
            $message = __('validation');
        }

        // Execute validation process
        $validator = Validator::make($request->all(), $rules, $message);

        // Throw an exception with status code 400 when validation fails
        if ($validator->fails()) {
            throw new \Exception(
                $validator->messages(),
                config('response.status.bad_request.code')
            );
        }
    }
}
