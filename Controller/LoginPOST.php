<?php

namespace Controller;

use Libs\BaseController;
use Libs\PasswordHasherHelper;
use Libs\Session;
use Model\UserModel;

class LoginPOST extends BaseController {

    public function action(){
        $qs = $this->getRequest()->getQueryString();
        $qStringArray = [];
        parse_str($qs, $qStringArray);

        Session::sessionStart();
        if(!is_null(Session::getEmail()) && strlen(Session::getEmail()) > 0){
            if(isset($qStringArray['redirect'])){
                $this->redirect($qStringArray['redirect']);
            }
            // sesion ya iniciada
            $this->redirect('/Home');
            return;
        }

        $this->setHttpStatusCode(200);
        $this->setTemplate(null);
        $data = $this->getRequest()->getBody();
        if(empty($data)) {
            Session::addToBag('login_error', 'Bad credentials');
            $this->redirect('/login');
            return;
        }
        $data = str_replace('%40', '@', $data);
        $qString = [];
        $data = mb_parse_str($data, $qString);
        if(!isset($qString['email']) || empty($qString['email']) || !isset($qString['password']) || empty($qString['password']) ){
            Session::addToBag('login_error', 'Bad credentials');
            $this->redirect('/login');
            return;
        }
        $userModel = new UserModel();
        $user = $userModel->findBy('email', $qString['email']);
        if(is_null($user)) {
            Session::addToBag('login_error', 'Bad credentials');
            $this->redirect('/login');
            return;
        }
        $validPwd = PasswordHasherHelper::checkPassword($qString['password'], $user->getPassword());
        if(!$validPwd){
            Session::addToBag('login_error', 'Bad credentials');
            $this->redirect('/login');
            return;
        }

        // Login exitoso
        $userModel->updateLoginTimeStamp($user->getId());
        Session::setEmail($user->getEmail());
        Session::setUserId($user->getId());
        Session::setLastActivityTimeStamp();
        $this->redirect('/');
    }
}

?>
