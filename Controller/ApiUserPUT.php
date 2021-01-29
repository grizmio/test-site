<?php

namespace Controller;


use Libs\BaseController;
use Model\UserModel;
use PreExecute\ApiLoginCheck;

class ApiUserPUT extends BaseController {
    public function __construct() {
        $this->addPreExecute(ApiLoginCheck::class);
    }

    public function action(){
        // Actualizar un usuario implica cambiar la contraseña si esta es desconocida
        $request = $this->getRequest();
        if(count($request->getInUrlParameters()) === 0) {
            $this->setHttpStatusCode(400);
            $this->setTemplate(null);
            return;
        }
        $userId = $request->getInUrlParameters()['userid'];
        $body = $request->getBody();
        $newUser = json_decode($body, true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $this->setHttpStatusCode(400);
            $this->setTemplate('invalid_input_json');
            return;
        }

        $userModel = new UserModel();
        try{
            $user = $userModel->findById($userId);
        }catch(\PDOException $e){
            $this->setHttpStatusCode(409);
            /*
             FIXME: Debe mostrar el campo duplicado, filtrar por tipo de error (duplicado u otro)
            */
            $this->setTemplate(null);
            return;
        }
        if($user === null){
            $this->setHttpStatusCode(404);
            $this->setTemplate(null);
            return;
        }

        $user->fillFromArray($newUser);
        $result = $userModel->updateUser($user);
        if($result != 1) {
            $this->setTemplate(null);
            $this->setHttpStatusCode(409);
            return;
        }

        $this->setTemplate(null);
        $this->setHttpStatusCode(200);
    }
}
