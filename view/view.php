<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:32
 */

class ViewClass {
    private $time;
    private $userName;
    private $password;
    private $errorMSG;
    private $loginSuccessMessage;

    function __construct() {
        $this->Time();
    }
    public function PageIsRefreshed(){
        if(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'){
        return true;
        }
    }
    public function Time() {
        setlocale(LC_ALL, "sv_SE");
        $this->time = (strftime("%A, den %d %B år %Y. Klockan är [%X]"));
    }
    public function errorMSGHandler($errorMSG) {
        $this->errorMSG = $errorMSG;
    }
    function loginForm() {
        $errorMSG = $this->errorMSG;
        $timeVariable = $this->time;

        $ret = "
        <h1>Login Application</h1>
        <form method=post enctype=multipart/form-data>
            <fieldset>
            <p></p>
            <p>$errorMSG</p>
                <legend>Login - Sign in with your Username and Password</legend>
                    <label for=UserNameID>Username :</label>
                        <input type=text size=20 name=userName id=userNameID value=>
                    <label for=PasswordID>Password  :</label>
                        <input type=password size=20  name=password id=PasswordID value=>
                    <label for=AutologinID>Keep me logged in :</label>
                        <input type=checkbox name=checked id=autoLoginID>
                        <input type=submit name=loginbutton>
            </fieldset>
            <p>$timeVariable</p>
        </form>
        ";
        return $ret;
    }

    function loggedInForm() {
        $loginSuccessMessage = $this->loginSuccessMessage;

        $timeVariable = $this->time;
        $ret = "
       <h1>Logged in to Application</h1>
        <form method=get enctype=multipart/form-data>
            <fieldset>
                <legend>You are now signed in as Admin</legend>
                <p>$loginSuccessMessage</p>
                    <input type=submit name=logoutbutton>
            </fieldset>
            <p>$timeVariable</p>
        </form>
        ";
        return $ret;
    }

    public function retrieveFormPostInfoIfLoginButtonClicked() {
        //variablerna måste kommas ihåg om sidan uppdateras
        if(isset($_POST["loginbutton"])){
            $this->userName = $_POST["userName"];
            $this->password = $_POST["password"];
            return true;
        }
    }
   /* public function retrieveFormPostInfoIfLogoutButtonClicked() {
        //variablerna måste kommas ihåg om sidan uppdateras
        if(isset($_POST["logoutbutton"])){
            var_dump('d');
            return true;
        }
    }*/
    public function loginMessage() {
        $this->loginSuccessMessage = "success";
    }

    function getUserName() {
        return $this->userName;
    }
    function getPassword() {
        return $this->password;
    }
}