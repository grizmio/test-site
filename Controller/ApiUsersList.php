<?php

namespace Controller;

use Libs\BaseController;
use Model\UserModel;

class ApiUsersList extends BaseController {

    public function action(){
        $this->setTemplate('index');
        $userModel = new UserModel();
        $usersObjects = $userModel->findAllUsers();
        $users = [];
        foreach($usersObjects as $user){
            $users[] = $user->getAsArray();
        }

        $this->setHttpStatusCode(200);
        $this->addVariable('users', $users);
        $this->addResponseHeader('Content-Type: application/json');
    }
}
