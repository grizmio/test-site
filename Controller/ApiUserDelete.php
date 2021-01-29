<?php

namespace Controller;

use Libs\BaseController;
use Model\UserModel;
use PreExecute\ApiLoginCheck;

class ApiUserDelete extends BaseController {

    public function __construct() {
        $this->addPreExecute(ApiLoginCheck::class);
    }

    public function action(){
        $request = $this->getRequest();
        if(count($request->getInUrlParameters()) === 0) {
            $this->setHttpStatusCode(400);
            $this->setTemplate(null);
            return;
        }

        $userId = $request->getInUrlParameters()['userid'];
        if(!ctype_digit($userId)){
            $this->setHttpStatusCode(400);
            $this->setTemplate(null);
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);

        if(empty($user)){
            $this->setHttpStatusCode(404);
            $this->setTemplate(null);
            return;
        }
        $rows = $userModel->deleteUserById($user->getId());
        if($rows > 0) {
            $this->setHttpStatusCode(204);
        }else if($rows === 0){
            $this->setHttpStatusCode(500);
        }
        $this->setTemplate(null);
        $this->addResponseHeader('Content-Type: application/json');
    }
}
