<?php

namespace Controller;

use Libs\BaseController;
use Libs\Session;
use Libs\PasswordHasherHelper;
use Model\UserModel;
use Libs\JWTHelper;

class ApiLoginPOST extends BaseController {
    public function __construct() {
        $this->setTemplate(null);
    }

    public function action() {
        Session::sessionStart();
        $data = json_decode($this->getBody(), true);

        if(json_last_error() !== JSON_ERROR_NONE) {
            $this->setHttpStatusCode(400);
            echo "Invalid format data.";
            return;
        }

        if(!isset($data['name']) || ! isset($data['password'])) {
            $this->setHttpStatusCode(400);
            echo "Missing authenticatin fields.";
            return;
        }

        $apiUserModel = new UserModel();
        $user = $apiUserModel->findBy('name', $data['name']);
        if(is_null($user)) {
            $this->setHttpStatusCode(404);
            echo "Not found.";
            return;
        }

        $ok = PasswordHasherHelper::checkPassword($data['password'], $user->getPassword());
        if(!$ok){
            $this->setHttpStatusCode(401);
            echo "Wrong credentials.";
            return;
        }

        if(!$user->isSuperUser()){
            $this->setHttpStatusCode(401);
            echo "USer not allowed.";
            return;
        }

        // Login exitoso
        $token = JWTHelper::buildToken($user->getName());
        $this->setTemplate('jwt');
        $this->addVariable('token', $token);
        $this->setHttpStatusCode(200);
    }
}

