<?php

/**
 * Constants File
 */
return [
    // Status code
    'status_code' => [
        // Successful Responses 2xx
        'success' => '200',

        // Redirection Responses 3xx
        'multiple_choices' => '300',
        'moved_permanently' => '301',

        // Client Error Responses
        'bad_request' => '400',
        'unauthorized' => '401',
        'forbidden' => '403',
        'not_found' => '404',
        'method_not_allowed' => '405',
        'request_timeout' => '408',

        // Server Error Responses
        'internal_server_error' => '500',
        'not_implemented' => '501',
        'bad_gateway' => '502',
        'service_unavailable' => '503',
    ],
];