<?php

namespace App\Logger;

use Illuminate\Support\Facades\Log;

/**
 * Logger Handler Class
 */
class Handler
{

    /**
     * Export success logs
     *
     * @param string $level
     * @param integer $status_code
     * @param string $message
     * @param array $data
     * @return void
     */
    public static function success_log($level = 'info', $status_code = 200, $message = "", $data = []): void
    {
        // Log information
        $context = array(
            'level' => $level,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
        );

        // Export logs
        Log::channel('success')->info('Success', $context);
    }

    /**
     * Export error logs
     *
     * @param string $level
     * @param integer $status_code
     * @param string $message
     * @param array $data
     * @return void
     */
    public static function error_log($level = 'error', $status_code = 500, $message = "", $data = []): void
    {
        // Log information
        $context = array(
            'level' => $level,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
        );

        // Export logs
        Log::channel('failure')->error('error', $context);
    }
}
