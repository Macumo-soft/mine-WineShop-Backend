<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Validations\Handler as ValidationHandler;

class Handler
{
    private $default_message = [];

    public function __construct()
    {
        $default_message = __('validation');
    }

    public static function default(Request $request, array $rules): void {
        // Validation Check
        ValidationHandler::validate($request, $rules);

        // Check if value exist
        ValidationHandler::checkArrayValueExists($request);

        // Check if there is no unknown parameter key
        ValidationHandler::checkUnknownParameter($request, $rules);
    }

    /**
     * Checks if request parameters matches with a given rule validation
     *
     * @param [type] $request
     * @param array $rules
     * @param array $message
     * @return void
     */
    public static function validate($request, $rules = [], $message = []): void
    {
        // Load message in validation.php, if $message variable is empty
        if (empty($message)) {
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

    /**
     * Check if there is value in each parameter
     * true - There is at least one value in request
     * false - There is no value in any parameter
     * @param Request $request
     * @return void
     */
    public static function checkArrayValueExists(Request $request): void
    {
        // Convert Request to array type parameters
        $request = $request->toArray();

        // Get value list from a request
        $value_list = array_values($request);

        // Throw an exception when value doesn't exist in any keys
        if (empty($value_list)) {
            throw new \Exception(
                __('validation.custom.check_array_value_exist'),
                config('response.status.bad_request.code')
            );
        }
    }

    /**
     * Check if there is no paramater that doesn't match with rules key
     *
     * @param Request $request
     * @param array $rules
     * @return void
     */
    public static function checkUnknownParameter(Request $request, array $rules): void
    {
        // Convert Request to array type parameters
        $request = $request->toArray();

        // Get value list from a request
        $key_list = array_keys($rules);

        // Throw an exception when value doesn't exist in any keys
        foreach ($request as $key => $value) {
            if (!in_array($key, $key_list)) {
                throw new \Exception(
                    __('validation.custom.check_unknown_parameter'),
                    config('response.status.bad_request.code')
                );
            }
        }
    }

    /**
     * Check if there is no paramater that doesn't match with rules key
     *
     * @param Request $request
     * @param array $rules
     * @return void
     */
    public static function checkAuthAttempt(Request $request): void
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw new \Exception(
                "User not found, please check email & password",
                config('response.status.bad_request.code')
            );
        }
    }

}
