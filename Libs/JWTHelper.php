<?php

namespace Libs;

// https://tools.ietf.org/html/rfc7519
class JWTHelper {
    public static int $expireSeconds = 900; // 900 -> 15 mins

    public static function buildToken(string $username) : string {
        $secret = getenv('JWT_SECRET');
        $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];
        $time = time();
        $payload = [
            'iat' => $time,
            'exp' => $time + self::$expireSeconds,
            // 'name' => $username
        ];


        $header = json_encode($header);
        $payload = json_encode($payload);
        $data = self::base64URLEncode($header).'.'.self::base64URLEncode($payload);
        return $data.'.'.self::base64URLEncode(hash_hmac('sha256', $data, $secret, true));
    }

    public static function validateToken(string $token) : bool {
        $tokenParts = explode('.', $token);
        $headers = $tokenParts[0];
        $payload = $tokenParts[1];

        $payloadObj = json_decode( self::base64URLDecode($payload));
        if(!isset($payloadObj->iat) || !isset($payloadObj->exp)) {
            return false;
        }

        if((time() > $payloadObj->iat + self::$expireSeconds)|| (time() > $payloadObj->exp ) ){
            return false;
        }

        $signature = $tokenParts[2];
        $data = $headers.'.'.$payload;
        $secret = getenv('JWT_SECRET');
        return $signature === self::base64URLEncode(hash_hmac('sha256', $data, $secret, true));
    }

    public static function decodeToken(string $token) : array {
        $tokenParts = explode('.', $token);
        $headers = self::base64URLDecode($tokenParts[0]);
        $payload = self::base64URLDecode($tokenParts[1]);
        return [json_decode($headers), json_decode($payload)];
    }

    public static function base64URLEncode(string $data) {
        // https://www.php.net/manual/es/function.base64-encode.php
        $b64 = base64_encode($data);
        $b64Url = rtrim($b64, '=');
        return str_replace(['+','/','='], ['-','_',''], $b64Url);
    }

    public static function base64URLDecode(string $data) {
        // https://www.php.net/manual/es/function.base64-encode.php
        return base64_decode(str_replace(['-','_'], ['+','/'], $data));
    }
}

