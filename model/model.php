<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:25
 */
class ModelClass {
    private $user = "user";
    private $pass = "pass";
    private $errorMSG;
    private $cookiePassword = "pazz";
    private $cookieExpirationTime;

    public function __construct() {
    }

    //checks if users login input is correct
    public function userInputOK($userName,$password) {

        if($userName === "")
            $this->errorMSG = "Missing username";
        else if($password === "")
            $this->errorMSG = "Missing password";
        else
            $this->errorMSG = "Wrong username and/or password";

        //if it is correct, returns true
        if($userName === $this->user && $password === $this->pass){
            return true;
        }
    }

    //starts one session to keep user logged in, and one session to store webbrowser information
    public function startSession() {
        if(!isset($_SESSION['LOGIN'])){
        $_SESSION['LOGIN'] = true;
            if(!isset($_SESSION['USERINFO'])) {
                $_SESSION['USERINFO'] = true;
                $userBrowser = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION["USERINFO"] = $userBrowser;
            }
            return true;
        }
    }
    //checks if the original broswer used is the same as the current one who wants to be logged in
    function ifSessionIsNotStolen() {
        if(isset($_SESSION["USERINFO"]) && $_SERVER['HTTP_USER_AGENT'] == $_SESSION["USERINFO"]){
            return true;
        }
    }

    //stores expirationtime into textfile
    function storeCookieExpirationTime($userCookieExpirationTime) {
        $this->cookieExpirationTime = $userCookieExpirationTime;
        file_put_contents("textfile.txt", $this->cookieExpirationTime );
    }
    //checks if cookie is manipulated
    function ifCookieIsNotManipulated($userCookieValue) {
        //reads from file where expirationtime is stored
        $this->myfile = file_get_contents("textfile.txt");
        //checks if the cookies value(password) checks out(should be "pazz")
        if($userCookieValue == $this->cookiePassword) {
            //if it does, the it checks if the time stored in cookie is more than the current time
            //if the stored time is set on a moment that is futher on than the current time, it has been manipulated
            if($this->myfile > time()){
                return true;
            }
        }
    }
    // check if a certain session exists
    function doesSessionExist() {
        if(isset($_SESSION['LOGIN'])){
            return true;
        }
    }
    //Getters for errormsg och
    public function getErrorMSG() {
        return $this->errorMSG;
    }
    public function getCookiePassword() {
        return $this->cookiePassword;
    }
}