<?php

use Illuminate\Support\Facades\Log;

/**
 * Logger Class
 */ 
class Logger {

    public function success($level, $message){
        $stack_trace = Exception::getTraceAsString;
    }

    // [2022-09-13 11:37:00] local.ERROR: 
    // Call to undefined method Monolog\Logger::success() {"exception":"[object] (Error(code: 0): Call to undefined method Monolog\\Logger::success() at /var/www/html/vendor/laravel/framework/src/Illuminate/Log/Logger.php:308)
}

?>