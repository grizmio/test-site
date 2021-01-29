<?php

namespace Libs;

abstract class BaseController {
    private array $responseHeaders = [];
    private int $httpStatusCode = 404;
    private ?string $template = '';
    private array $data = [];
    private array $preExecute = [];
    private array $postExecute = [];

    private Route $route;
    private Request $request;

    public function addVariable($var, $value): self {
        $this->data[$var] = $value;
        return $this;
    }

    public function __invoke() {
        if(!empty($this->preExecute)){
            foreach($this->preExecute as $preExecClassName) {
                $preExec = new $preExecClassName();
                $request = $this->getRequest();
                if(!$preExec($request->getBody(), $request->getInUrlParameters(),
                             $request->getQueryStringParams(), $request->getQueryString(),
                             $request->getHeaders())){
                    return;
                }
            }
        }
        $this->action();
        http_response_code($this->httpStatusCode);
        foreach($this->responseHeaders as $header){
            header($header);
        }

        if(!empty($this->postExecute)){
            foreach($this->postExecute as $postExecClassName) {
                $postExec = new $postExecClassName();
                $postExec();
            }
        }

        if(empty($this->template)){
            return;
        }

        $controllerName = mb_substr(strrchr(get_class($this), '\\'), 1);
        $templateFilePath = $controllerName.DIRECTORY_SEPARATOR.$this->template;

        View::render($templateFilePath, $this->data);
    }

    public function addResponseHeader(string $header) : self {
        $this->responseHeaders[] = $header;
        return $this;
    }

    public function setHttpStatusCode(int $httpStatusCode) : self {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }

    public function setTemplate(?string $template) : self {
        $this->template = $template;
        return $this;
    }

    public function addPreExecute(string $className) : self {
        $this->preExecute[] = $className;
        return $this;
    }

    public function addPostExecute(string $className) : self {
        $this->postExecute[] = $className;
        return $this;
    }

    public function getresponseHeaders() : ?array {
        return $this->responseHeaders;
    }

    public function setRoute(Route $route) : self {
        $this->route = $route;
        return $this;
    }

    public function getRoute() : Route {
        return $this->route;
    }

    public function setRequest(Request $request) : self {
        $this->request = $request;
        return $this;
    }

    public function getRequest() : Request {
        return $this->request;
    }

    public function redirect(string $path) {
        $schema = mb_substr(strtolower($_SERVER['SERVER_PROTOCOL']),0, strpos($_SERVER['SERVER_PROTOCOL'], '/'));
        $host = $_SERVER['HTTP_HOST'];
        if(mb_strpos($path, '/') === 0){
            $path = mb_substr($path, 1);
        }
        $this->setHttpStatusCode(302);
        $this->setTemplate(null);
        $this->addResponseHeader("Location: $schema://$host/$path");
    }

    // Al invocar el controlador, antes del render se ejecuta el metodo "action"
    public function action(){
        throw new \Exception('Not implemented');
    }

}
