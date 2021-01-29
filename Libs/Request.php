<?php

namespace Libs;

class Request {
    private array $queryStringParams = [];
    private string $queryString = '';
    private $inUrlParameters = [];
    private array $headers;
    private string $body;
    private string $uri = "";

    function __construct() {
    }

    public function getQueryStringParams() : array {
        return $this->queryStringParams;
    }

    public function setQueryStringParams(array $queryStringParams) : self {
        $this->queryStringParams = $queryStringParams;
        return $this;
    }

    public function getQueryString() : string {
        return $this->queryString;
    }

    public function setQueryString(string $queryString) : self {
        $this->queryString = $queryString;
        return $this;
    }

    public function getInUrlParameters() : array {
        return $this->inUrlParameters;
    }

    public function setInUrlParameters(array $inUrlParameters) : self {
        $this->inUrlParameters = $inUrlParameters;
        return $this;
    }

    public function setHeaders(array $headers) : self {
        $this->headers = $headers;
        return $this;
    }

    public function getHeaders() : array {
        return $this->headers;
    }

    public function setBody(string $body) : self {
        $this->body = $body;
        return $this;
    }

    public function getBody() : string {
        return $this->body;
    }

    public function setURI(string $uri) : self {
        $this->uri = $uri;
        return $this;
    }

    public function getURI() : string {
        return $this->uri;
    }

}
