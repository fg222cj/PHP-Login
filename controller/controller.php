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

    //creates instances of other classes
    public function __construct() {
        $this->view = new ViewClass();
        $this->model = new ModelClass();

    }
    //direct errormessages from model to view
    function errorMSGControll() {
        $this->errorMSG = $this->model->getErrorMSG();
        $this->view->errorMSGHandler($this->errorMSG);
    }

    //controlls the flow of the forms
    public function formControll() {

        //allways checks if the user want to log out first
        //ifUserClickedLogoutButton() unsets session/cookies
        if($this->view->ifUserClickedLogoutButton()){
            return $this->view->loginForm();
        }

        //checks if there exists a session, if so returns true
        if($this->model->doesSessionExist()){
            //then checks if the session is stolen
            //ifSessionIsNotStolen() stores the original webbrowser the user logged in with and checks
            //if someone else is using it with another browser
            if($this->model->ifSessionIsNotStolen()){
                //it is doesn't find anything sketchy, it logs user in
                return $this->view->loggedInForm();
            }
            //if there is not any session, i checks if there exists a cookie
        } elseif($this->view->doesCookieExist()){
            //if so, store the value of the cookie
            $this->view->getCookieValues();
            //If the vaues are seems fine, its logs user in and start a new session
            if($this->model->ifCookieIsNotManipulated($this->view->getUserCookieValue())){
                //renders successful inlog message
                $this->view->loginWithCookie();
                $this->model->startSession();
                return $this->view->loggedInForm();
               //If the vaues are wrong(stringpassword or time manipulated) it unsets session/cookies and logs user out
            } else {
                //logout message
                $this->view->logoutFaultyCookie();
                $this->view->unsetCookie();
                $this->view->unsetSession();
                return $this->view->loginForm();
            }
        //if there isn't an session or a cookie, it creates a cookie and stores the expiration date
        } else {
            $this->view->setCookie($this->model->getCookiePassword());
            $this->model->storeCookieExpirationTime($this->view->getCookieExpiration());
        }


        //if the user clicks loginbutton
        if ($this->view->retrieveFormPostInfoIfLoginButtonClicked()) {
            //get the input username and password
            $this->userName = $this->view->getUserName();
            $this->password = $this->view->getPassword();

            //if the users input checks out it starts a session
            if($this->model->userInputOK($this->userName,$this->password)) {
                $this->model->startSession();
                $this->view->loginWithoutCookieMessage();
                //if a cookie doesn't exist then it creates one and stores the expiration date
                if(!$this->view->doesCookieExist()){
                    $this->view->setCookie($this->model->getCookiePassword());
                    $this->model->storeCookieExpirationTime($this->view->getCookieExpiration());
                }
            //if the user input was fine, user is logged in
                return $this->view->loggedInForm();
            }else {
                // if the user input didn't check out, it calls the errorMSG function
                $this->errorMSGControll();
            }
        }
        //if nothing checks out in this formControll() function, you will be logged out
        return $this->view->loginForm();
    }
}