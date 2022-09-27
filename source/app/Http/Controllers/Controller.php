<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create array type variables from request parameters
     *
     * @param Request $request
     * @param array $rules
     * @return array
     */
    public function requestHandler(Request $request, array $rules): array
    {
        // Get all key list from an array
        $key_list = array_keys($rules);

        // Request
        $request_param = array();

        // Loop key list and create array type request parameter
        // eg. $request_param['wineId'] = $request['wineId']
        foreach ($key_list as $key) {
            $request_param[$key] = $request[$key];
        }

        return $request_param;
    }
}
