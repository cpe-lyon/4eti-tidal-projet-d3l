<?php

namespace AttributesRouter;

require_once './d3l/attributes/Route.php';

use AttributesRouter\Attribute\Route;

class Router {

    private array $routes = [];

    public function __construct(
        array $controllers = [],
        private string $baseURI = '',
    ) {
        if (!empty($controllers)) {
            $this->addRoutes($controllers);
        }
    }


    public function setBaseURI(string $baseURI): void {
        $this->baseURI = $baseURI;
    }

    public function addRoutes(array $controllers): void {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $reflectionMethod) {
                $routeAttributes = $reflectionMethod->getAttributes(Route::class);

                foreach ($routeAttributes as $routeAttribute) {
                    $route = $routeAttribute->newInstance();
                    $this->routes[$route->getName()] = [
                        'class'  => $reflectionMethod->class,
                        'method' => $reflectionMethod->name,
                        'route'  => $route,
                    ];
                }
            }
        }
    }


    public function match(): ?array {
        $request = $_SERVER['REQUEST_URI'];

        if (!empty($this->baseURI)) {
            $baseURI = preg_quote($this->baseURI, '/');
            $request = preg_replace("/^{$baseURI}/", '', $request);
        }
        $request = (empty($request) ? '/': $request);

        foreach ($this->routes as $route) {
            if ($this->matchRequest($request, $route['route'], $params)) {
                return [
                    'class'  => $route['class'],
                    'method' => $route['method'],
                    'params' => $params,
                ];
            }
        }

        return null;
    }

    protected function convert_to_type(string $input){
        if(preg_match("/\d+/", $input)){
            return (int) $input;
        }

        if(preg_match("/^[\d]+(|\.[\d]+)$/", $input)){
            return (float) $input;
        }

        return $input;
    }


    private function matchRequest(string $request, Route $route, ?array &$params = []): bool {
        $requestArray = explode('/', $request);
        $pathArray = explode('/', $route->getPath());

        // Remove empty values in arrays
        $requestArray = array_values(array_filter($requestArray, 'strlen'));
        $pathArray = array_values(array_filter($pathArray, 'strlen'));

        if (!(count($requestArray) === count($pathArray))
            || !(in_array($_SERVER['REQUEST_METHOD'], $route->getMethods(), true))) {
            return false;
        }

        foreach ($pathArray as $index => $urlPart) {
            if (isset($requestArray[$index])) {
                if (str_starts_with($urlPart, '{')) {
                    $routeParameter = explode(' ', preg_replace('/{([\w\-%]+)(<(.+)>)?}/', '$1 $3', $urlPart));
                    $paramName = $routeParameter[0];
                    $paramRegExp = (empty($routeParameter[1]) ? '[\w\-]+': $routeParameter[1]);

                    if (preg_match('/^' . $paramRegExp . '$/', $requestArray[$index])) {
                        $params[$paramName] = $this->convert_to_type($requestArray[$index]);
                        continue;
                    }
                } elseif ($urlPart === $requestArray[$index]) {
                    continue;
                }
            }

            return false;
        }

        return true;
    }

 
    public function generateUrl(string $routeName, array $parameters = []): string {
        if (!isset($this->routes[$routeName])) {
            throw new \OutOfRangeException(sprintf(
                'The route does not exist. Check that the given route name "%s" is valid.',
                $routeName
            ));
        }

        $route = $this->routes[$routeName]['route'];
        $path = $route->getPath();

        if ($route->hasParams()) {
            $routeParams = $route->fetchParams();

            if ($missingParameters = array_diff_key($routeParams, $parameters)) {
                throw new \InvalidArgumentException(sprintf(
                    'The following parameters are missing for generating the route "%s": %s',
                    $routeName,
                    implode(', ', array_keys($missingParameters))
                ));
            }

            foreach ($routeParams as $paramName => $regex) {
                $regex = (!empty($regex) ? $regex : Route::DEFAULT_REGEX);

                if (!preg_match("/^$regex$/", $parameters[$paramName])) {
                    throw new \InvalidArgumentException(sprintf(
                        'The "%s" route parameter value given does not match the regular expression',
                        $paramName
                    ));
                }
                $path = preg_replace('/{' . $paramName . '(<.+?>)?}/', $parameters[$paramName], $path);
            }
        }

        return $this->baseURI . $path;
    }
}