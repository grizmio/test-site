<?php

namespace PreExecute;

use Libs\Session;
use Libs\JWTHelper;

class ApiLoginCheck {

    public function __invoke(?string $body, ?array $inUrlParameters, ?array $queryStringParams, ?string $queryString, ?array $headers) : bool {
        if(!isset($headers['Authorization'])){
            http_response_code(401);
            echo 'Missing Authorization Bearer.';
            return false;
        }

        if(strpos($headers['Authorization'], ' ')===FALSE){
            http_response_code(401);
            echo 'Wrong Authorization Bearer format.';
            return false;
        }

        list($x, $token) = explode(' ', $headers['Authorization']);

        $valid = JWTHelper::validateToken($token);

        if(!$valid) {
            http_response_code(401);
            echo 'Invalid credentials.';
            return false;
        }
        list($jwtHeaders, $jwtPayload) = JWTHelper::decodeToken($token); // son objetos, NO JSON
        return true;
    }

}
