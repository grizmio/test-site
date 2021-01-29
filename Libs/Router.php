<?php

namespace Libs;

class Router {
    private static array $POSTRoutes = [];
    private static array $GETRoutes = [];
    private static array $PUTRoutes = [];
    private static array $PATCHRoutes = [];
    private static array $DELETERoutes = [];

    public static function getRoute(string $method, string $originaURI, Request $request): Route {
        switch ($method) {
            case 'GET':
                $arr = 'GETRoutes';
                break;
            case 'POST':
                $arr = 'POSTRoutes';
                break;
            case 'DELETE':
                $arr = 'DELETERoutes';
                break;
            case 'PUT':
                $arr = 'PUTRoutes';
                break;
            case 'PATCH':
                $arr = 'PATCHRoutes';
                break;
            default:
                throw new MethodNotFoundException("Method: ${method} not supported");
                break;
        }

        $uri = $originaURI;
        $pos = strpos($uri, '?');
        $queryString = '';
        if($pos !== FALSE) {
            $queryString = mb_substr($uri, $pos+1);
            $uri = mb_substr($uri, 0, $pos);
        }

        if(strlen($uri) > 1 && mb_substr($uri, -1) === '/'){
            $uri = rtrim($uri, '/');
        }

        $queryStringParams = [];
        parse_str($queryString, $queryStringParams);

        foreach(self::$$arr as $pattern => $route){
            $params = self::parseUrl($uri, $pattern);
            if(!is_null($params)){
                $request->setInUrlParameters($params)
                        ->setQueryStringParams($queryStringParams)
                        ->setQueryString($queryString);
                return $route->setUri($originaURI);
            }
        }

        throw new RouteNotFoundException("${method} ${uri} NOT FOUND");
    }

    public static function addGETRoute(Route $route){
        self::$GETRoutes[$route->getUriPattern()] = $route;
    }

    public static function addPOSTRoute(Route $route){
        self::$POSTRoutes[$route->getUriPattern()] = $route;
    }

    public static function addPUTRoute(Route $route){
        self::$PUTRoutes[$route->getUriPattern()] = $route;
    }

    public static function addDELETERoute(Route $route){
        self::$DELETERoutes[$route->getUriPattern()] = $route;
    }

    public static function addPATCHRoute(Route $route){
        self::$PATCHRoutes[$route->getUriPattern()] = $route;
    }

    public static function callControllerAction(Route $route){
        $controllerName = $route->getControllerName();
        $controllerAction = $route->getAction();
        $controllerInstance = new $controllerName;
        $controllerInstance->$controllerAction();
    }

    public static function parseUrl($request_url, $url_pattern) : ?array {
        $new_pattern = [];

        $pattern_arr = explode('/', $url_pattern);
        $inUrlParams = [];

        foreach ($pattern_arr as $index => $patter_chunk) {
            if( strpos($patter_chunk, ':') === 0 ){
                $inUrlParams[$index] = substr($patter_chunk, 1);
                $patter_chunk = '.*';
            }
            $new_pattern[] = $patter_chunk;
        }

        $new_pattern = str_replace('/', '\/', implode('/', $new_pattern));
        $new_pattern = "/(?i)^$new_pattern\$/";

        $m = preg_match($new_pattern, $request_url);

        if($m === 0) {
            return null;
        }
        $request_url_arr = explode('/', $request_url);
        $params = [];

        foreach($inUrlParams as $index => $p_name) {
            $params[$p_name] = $request_url_arr[$index];
        }

        return $params;
    }

}
