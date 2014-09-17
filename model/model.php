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
            return true;
        }
    }


    public function getErrorMSG() {
        return $this->errorMSG;
    }


}