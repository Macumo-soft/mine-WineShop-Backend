<?php

/**
 * Constants File
 */
return [
    // Status code
    'status' => [
        // Successful Responses 2xx
        'success' => [
            'code' => '200',
            'message' => 'Success',
        ],

        // Redirection Responses 3xx
        'multiple_choices' => [
            'code' => '300',
            'message' => 'Multiple choices',
        ],
        'moved_permanently' => [
            'code' => '301',
            'message' => 'This page is moved permanently',
        ],

        // Client Error Responses
        'bad_request' => [
            'code' => '400',
            'message' => 'Bad request',
        ],
        'unauthorized' => [
            'code' => '401',
            'message' => 'User unauthorized',
        ],
        'forbidden' => [
            'code' => '403',
            'message' => 'User unauthorized',
        ],
        'not_found' => [
            'code' => '404',
            'message' => 'Page not found',
        ],
        'method_not_allowed' => [
            'code' => '405',
            'message' => 'This method is not allowed',
        ],
        'request_timeout' => [
            'code' => '408',
            'message' => 'Request timeout',
        ],

        // Server Error Responses
        'internal_server_error' => [
            'code' => '500',
            'message' => 'Internal server error',
        ],
        'not_implemented' => [
            'code' => '501',
            'message' => 'Not implemented',
        ],
        'bad_gateway' => [
            'code' => '502',
            'message' => 'Bad gateway',
        ],
        'service_unavailable' => [
            'code' => '503',
            'message' => 'Service unavailable',
        ],
    ],
];
