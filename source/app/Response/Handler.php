<?php

namespace App\Response;

use App\Logger\Handler as Logger;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Handler extends Response
{
    /****************************
     * PUBLIC FUNCTIONS
     ****************************/

    /**
     * Return JSON format success response
     *
     * @param array $data
     * @return array
     */
    public static function success($data)
    {
        // Export success log
        Logger::success_log('info', 200, '', $data);
        // Log::channel('success')->info('error');

        // Return success response
        return Handler::response(200, null, $data);
    }

    /**
     * Return JSON format error response
     *
     * @param array $data
     * @return array
     */
    public static function error($status_code = 400, $message = null, $data = [])
    {
        // Export error info
        Logger::error_log('error', $status_code, $message, $data);

        // Return error response
        return Handler::response($status_code, $message, $data);
    }

    /****************************
     * PRIVATE FUNCTIONS
     ****************************/

    /**
     * Base response function
     *
     * @param integer $status_code
     * @param [type] $message
     * @param array $data
     * @return array
     */
    private static function response($status_code = 200, $message = null, $data = [])
    {
        // check if $message is object and transforms it into an array
        if (is_object($message)) {$message = $message->toArray();}

        // Get status config that matches with given $status_code
        $status_config = array_filter(config('response.status'), function ($val) use ($status_code) {
            return $val['code'] == $status_code;
        });

        // If $status_config does not exist, return unexpected error
        if (count($status_config) !== 1) {
            return 'Unexpected error occured, please check failure logs';
        }

        // Get string type message from an array
        $status_message = array_column($status_config, 'message')[0];

        $data = array(
            'status_code' => $status_code,
            'status_message' => $status_message,
            'message' => $message,
            'data' => $data,
        );

        // return an response
        return response()->json($data, $status_code);
    }

}
