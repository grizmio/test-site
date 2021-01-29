<?php

namespace Controller;

use Libs\BaseController;
use Model\UserModel;

class ApiUserShow extends BaseController {

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
        $this->setTemplate('index');
        $this->setHttpStatusCode(200);
        $this->addVariable('user', $user->getAsJson());
        $this->addResponseHeader('Content-Type: application/json');
    }
}
