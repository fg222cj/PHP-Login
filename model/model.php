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
    private $cookiePass = "pazz";
    private $cookieExpirationTime;

    public function __construct() {
    }

    public function userInputOK($userName,$password) {

        if($userName === "")
            $this->errorMSG = "Missing username";
        else if($password === "")
            $this->errorMSG = "Missing password";
        else
            $this->errorMSG = "Wrong username and/or password";

        if($userName === $this->user && $password === $this->pass){
            return true;
        }
    }
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
    function ifSessionIsNotStolen() {
        if(isset($_SESSION["USERINFO"]) && $_SERVER['HTTP_USER_AGENT'] == $_SESSION["USERINFO"]){
            return true;
        }
    }

    function storeCookieExpirationTime($userCookieExpirationTime) {
        $this->cookieExpirationTime = $userCookieExpirationTime;
        file_put_contents("textfile.txt", $this->cookieExpirationTime );
    }
    function ifCookieIsNotManipulated($userCookieValue) {
        $this->myfile = file_get_contents("textfile.txt");

        if($userCookieValue == $this->cookiePass) {
            if($this->myfile > time()){
                return true;
            }
        }
    }

    function doesSessionExist() {
        if(isset($_SESSION['LOGIN'])){
            return true;
        }
    }
    public function getErrorMSG() {
        return $this->errorMSG;
    }
    public function getCookiePass() {
        return $this->cookiePass;
    }
}