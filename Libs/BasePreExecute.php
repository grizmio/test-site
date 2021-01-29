<?php

namespace Libs;

class BasePreExecute {

    public function redirect(string $path) {
        $schema = mb_substr(strtolower($_SERVER['SERVER_PROTOCOL']),0, strpos($_SERVER['SERVER_PROTOCOL'], '/'));
        $host = $_SERVER['HTTP_HOST'];
        if(mb_strpos($path, '/') === 0){
            $path = mb_substr($path, 1);
        }
        http_response_code(302);
        header("Location: $schema://$host/$path");
    }
}
