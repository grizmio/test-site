<?php

namespace Libs;

class Session {
    public static function sessionStart(?array $options = null) : bool {
        if(is_null($options)) {
            $options = [
                'cookie_lifetime' => 3600,
            ];
        }
        return session_start($options);
    }

    public static function sessionStop() : bool {
        if(isset($_SESSION['email']))
            unset($_SESSION['email']);

        if(isset($_SESSION['user_id']))
            unset($_SESSION['user_id']);

        if(isset($_SESSION['last_activity_time_stamp']))
            unset($_SESSION['last_activity_time_stamp']);

        session_unset();  // void
        return session_destroy();
    }
    public static function sessionStatus() : int {
        return session_status();
    }

    public static function setEmail(string $email) : Session {
        $_SESSION['email'] = $email;
        return new static;
    }

    public static function getEmail() : ?string {
        if(isset($_SESSION['email']))
            return $_SESSION['email'];
        return null;
    }

    public static function setUserId(int $user_id) : Session {
        $_SESSION['user_id'] = $user_id;
        return new static;
    }

    public static function getUserId() : ?int {
        if(isset($_SESSION['user_id']))
            return $_SESSION['user_id'];
        return null;
    }

    public static function addToBag(string $key, $value) : Session {
        if(!isset($_SESSION['bag']))
            $_SESSION['bag'] = [];

        $_SESSION['bag'][$key] = $value;
        return new static;
    }

    public static function getBag() : ?array {
        if(isset($_SESSION['bag']))
            return $_SESSION['bag'];
        return null;
    }

    public static function getLastActivityTimeStamp() : ?int {
        if(isset($_SESSION['last_activity_time_stamp']))
            return $_SESSION['last_activity_time_stamp'];
        return null;
    }

    public static function setLastActivityTimeStamp(?int $lastActivityTimeStamp=null) : Session {
        if(is_null($lastActivityTimeStamp)) {
            $lastActivityTimeStamp = time();
        }
        $_SESSION['last_activity_time_stamp'] = $lastActivityTimeStamp;
        return new static;
    }
}
