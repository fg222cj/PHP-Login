<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:25
 */
require_once("./view/view.php");
require_once("./model/model.php");

class ControllerClass {
    private $userName;
    private $password;
    private $errorMSG;


    public function __construct() {
        $this->view = new ViewClass();
        $this->model = new ModelClass();

    }
    //funktion som skickar vidare felmed.
    function errorMSGControll() {
        $this->errorMSG = $this->model->getErrorMSG();
        $this->view->errorMSGHandler($this->errorMSG);
    }

    //hanterar alla
    public function formControll() {


        if($this->view->ifUserClickedLogoutButton()){
            return $this->view->loginForm();
        }
        if($this->model->doesSessionExist()){
            return $this->view->loggedInForm();

        } elseif($this->view->doesCookieExist()){
            $this->view->lognWithCookie();
            $this->model->startSession();
            return $this->view->loggedInForm();

        } else {

            $this->view->setCookie($this->model->getCookiePass());
        }


        if ($this->view->retrieveFormPostInfoIfLoginButtonClicked()) {
            $this->userName = $this->view->getUserName();
            $this->password = $this->view->getPassword();

            if($this->model->userInputOK($this->userName,$this->password)) {
                $this->model->startSession();
                $this->view->loginWithoutCookieMessage();

                if(!$this->view->doesCookieExist()){
                    $this->view->setCookie($this->model->getCookiePass());
                }

                return $this->view->loggedInForm();
            }else {
                $this->errorMSGControll();
            }
        }
        return $this->view->loginForm();
    }
}