<?php

namespace Controller;

use Entity\User;
use Libs\BaseController;
use Libs\ShortPasswordException;
use PreExecute\ApiLoginCheck;
use Model\UserModel;

class ApiUserPOST extends BaseController {

    public function __construct() {
        $this->addPreExecute(ApiLoginCheck::class);
    }

    public function action(){
        $body = $this->getBody();
        $newUser = json_decode($body, true);

        if(json_last_error() !== JSON_ERROR_NONE){
            $this->setHttpStatusCode(400);
            $this->setTemplate('invalid_input_json');
            return;
        }

        $user = new User();
        $user->fillFromArray($newUser);
        if(!$user->isValid()){
            $this->setHttpStatusCode(400);
            $this->setTemplate('missing_properties');
            return;
        }
        $userModel = new UserModel();
        try{
            $lastInsertedId = $userModel->saveNewUser($user);
        }catch(ShortPasswordException $e) {
            $this->setHttpStatusCode(400);
            $this->setTemplate('short_password');
            return;
        }catch(\PDOException $e){
            $this->setHttpStatusCode(409);
            /*
             FIXME: Debe mostrar el campo duplicado, filtrar por tipo de error (duplicado u otro)
            */
            $this->setTemplate(null);
            return;
        }

        $this->setTemplate(null);
        $this->setHttpStatusCode(201);
        $this->redirect("/api/users/$lastInsertedId");
    }
}
