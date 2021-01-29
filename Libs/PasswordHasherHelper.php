<?php

namespace Libs;

class PasswordHasherHelper {
    public static string $algo = PASSWORD_DEFAULT;
    public static function hash(string $password) {
        return password_hash($password, self::$algo);
    }
    public static function checkPassword(string $password, string $hashedPassword) : bool {
        return password_verify($password, $hashedPassword);
    }
}
