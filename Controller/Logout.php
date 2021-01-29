<?php

namespace Controller;

use Libs\BaseController;
use Libs\Session;

class Logout extends BaseController {

    public function action(){
        Session::sessionStart();
        if(is_null(Session::getEmail()) || strlen(Session::getEmail()) === 0){
            // No hay sesion, limpiamos todo
            Session::sessionStop();
            if(isset($qStringArray['redirect'])){
                $this->redirect($qStringArray['redirect']);
            }
            $this->redirect('/Home');
            return;
        }

        Session::sessionStop();
        $this->redirect('/');
    }
}

?>
