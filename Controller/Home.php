<?php

namespace Controller;

use Libs\BaseController;
use Model\UserModel;
use PreExecute\LoginCheck;
use Libs\Session;

class Home extends BaseController {

    public function __construct(){
        $this->addPreExecute(LoginCheck::class);
    }

    public function action(){
        $this->setTemplate('index');
        $this->setHttpStatusCode(200);
        $userModel = new UserModel();
        $user = $userModel->findById(Session::getUserId());
        $this->addVariable('user', $user);
    }
}

?>
