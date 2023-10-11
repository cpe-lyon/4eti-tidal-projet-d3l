<?php

namespace D3l\Middleware;

require_once './d3l/middleware/exceptions/RouteNotFoundException.php';
require_once './d3l/templates/Template.php';

use D3l\Middleware\Exceptions\RouteNotFoundException;
use D3l\Template\Template;

class ExceptionsMiddleware extends Middleware
{
    public function handle($request, $nextMiddleware)
    {
        try { // Try to handle the request with the next middleware
            $response = $nextMiddleware->handle($request);
            return $response;
            
        } catch (RouteNotFoundException $e) { // Catch route not found exceptions
            http_response_code($e->getCode());
            //display error page
            $context = array(
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            );
            $engine = new Template($context);
            $output = $engine->render('404.html');
            echo $output;
        }
        
        catch ( \Exception $e ) { // Catch all other exceptions
            http_response_code(500);
            //display error page
            $context = array(
                'code' => 500,
                'message' => 'Internal Server Error'
            );
            $engine = new Template($context);
            $output = $engine->render('500.html');
            echo $output;
        }
    }
}
