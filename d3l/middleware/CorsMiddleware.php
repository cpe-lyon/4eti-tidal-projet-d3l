<?php

namespace D3l\Middleware;

require_once './d3l/middleware/Middleware.php';

class CorsMiddleware extends Middleware
{
    public function handle($request, $nextMiddleware)
    {
        // Allow CORS
        $allowedOrigins = [
            'localhost',
        ];

        // Allow CORS for all origins
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        // Allow CORS for specific origins
        if (in_array($origin, $allowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
        }

        return parent::handle($request, $nextMiddleware);    }
}
