<?php

namespace Libs;

class Route {
    private string $controllerName;
    private string $uriPattern;
    private string $uri = '';

    function __construct(string $uriPattern, ?string $controller=null) {
        $this->uriPattern = $uriPattern;
        $this->controllerName = $controller;
    }

    function getControllerName() : string {
        return $this->controllerName;
    }

    function setUriPattern(string $uriPattern):self{
        $this->uriPattern = $uriPattern;
        return $this;
    }

    function getUriPattern() : string {
        return $this->uriPattern;
    }

    function getUri() : string {
        return $this->uri;
    }

    function setUri(string $uri) : self {
        $this->uri = $uri;
        return $this;
    }

}
