<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApiResponser extends Response
{
    public static function success($status_code = 200, $message = null)
    {
        // check if $message is object and transforms it into an array
        if (is_object($message)) {$message = $message->toArray();}

        switch ($status_code) {
            case config('status_code.success'): // 200
                $code_message = '';
                break;

            default:
                $code_message = 'error_occured';
                break;
        }

        $data = array(
            'status_code' => $status_code,
            'message' => $code_message,
            'data' => $message,
        );

        // return an error
        return response()->json($data, $status_code);
    }

    public static function error($status_code = 400, $message = null)
    {
        // check if $message is object and transforms it into an array
        if (is_object($message)) {$message = $message->toArray();}

        switch ($status_code) {
            default:
                $code_message = 'error_occured';
                break;
        }

        $data = array(
            'status_code' => $status_code,
            'message' => $code_message,
            'data' => $message,
        );

        // return an error
        return response()->json($data, $status_code);
    }

}
