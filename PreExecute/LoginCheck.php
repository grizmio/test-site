<?php

namespace PreExecute;

use Libs\Session;
use Libs\BasePreExecute;

class LoginCheck extends BasePreExecute {
    public function __invoke(?string $body, ?array $inUrlParameters, ?array $queryStringParams, ?string $queryString, ?array $headers) : bool {
        Session::sessionStart();

        if(is_null(Session::getEmail()) || mb_strlen(Session::getEmail()) === 0) {
            $this->redirect("/login?redirect=".$_SERVER['REQUEST_URI']);
            return false;
        }

        $loginTimeStamp = Session::getLastActivityTimeStamp();
        $timeoutSeconds = intval(getenv('USER_SESSION_TIMEOUT'));
        if($loginTimeStamp + $timeoutSeconds < time()) {
            Session::sessionStop();
            $this->redirect("/login?redirect=".$_SERVER['REQUEST_URI']);
            return false;
        }

        Session::setLastActivityTimeStamp();
        return true;
    }

}
