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
            if($this->model->ifSessionIsNotStolen()){
            return $this->view->loggedInForm();

            }
        } elseif($this->view->doesCookieExist()){
            $this->view->getCookieValues();
            if($this->model->ifCookieIsNotManipulated($this->view->getUserCookieValue())){

                $this->view->loginWithCookie();
                $this->model->startSession();
                return $this->view->loggedInForm();

            } else {
                $this->view->logoutFaultyCookie();
                $this->view->unsetCookie();
                $this->view->unsetSession();
                return $this->view->loginForm();
            }

        } else {
            $this->view->setCookie($this->model->getCookiePass());
            $this->model->storeCookieExpirationTime($this->view->getCookieExpiration());

        }
        if ($this->view->retrieveFormPostInfoIfLoginButtonClicked()) {
            $this->userName = $this->view->getUserName();
            $this->password = $this->view->getPassword();

            if($this->model->userInputOK($this->userName,$this->password)) {
                $this->model->startSession();
                $this->view->loginWithoutCookieMessage();

                if(!$this->view->doesCookieExist()){
                    $this->view->setCookie($this->model->getCookiePass());
                    $this->model->storeCookieExpirationTime($this->view->getCookieExpiration());
                }

                return $this->view->loggedInForm();
            }else {
                $this->errorMSGControll();
            }
        }

        return $this->view->loginForm();
    }
}