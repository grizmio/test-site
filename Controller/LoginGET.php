<?php

namespace Controller;

use Libs\BaseController;
use Libs\Session;

class LoginGET extends BaseController {

    public function action(){
        Session::sessionStart();
        $bag = Session::getBag();
        if(isset($bag['login_error'])){
            $this->addVariable('error', $bag['login_error']);
        }

        $this->setHttpStatusCode(200);
        $this->setTemplate('index');
    }
}

?>
