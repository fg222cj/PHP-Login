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
    private $message;

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
        $message = $this->message;
        $timeVariable = $this->time;

        $ret = "
        <h1>Login Application</h1>
        <form method=post enctype=multipart/form-data>
            <fieldset>
            <p>$message</p>
            <p>$errorMSG</p>
                <legend>Login - Sign in with your Username and Password</legend>
                    <label for=UserNameID>Username :</label>
                        <input type=text size=20 name=userName id=userNameID value=>
                    <label for=PasswordID>Password  :</label>
                        <input type=password size=20  name=password id=PasswordID value=>
                    <label for=AutologinID>Keep me logged in :</label>
                        <input type=checkbox name=checked id=autoLoginID>
                        <input type=submit name=loginbutton value=Login>
            </fieldset>
            <p>$timeVariable</p>
        </form>
        ";
        return $ret;
    }

    function loggedInForm() {
        $message = $this->message;

        $timeVariable = $this->time;
        $ret = "
       <h1>Logged in to Application</h1>
        <form method=post enctype=multipart/form-data>
            <fieldset>
                <legend>You are now signed in as Admin</legend>
                <p>$message</p>
                    <input type=submit name=logoutbutton value=Logout>
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
    function ifUserClickedLogoutButton() {
        if (isset($_POST["logoutbutton"])) {
            setcookie ("Cookie", "", time() - 300);
            unset($_SESSION['LOGIN']);
            unset($_SESSION['USER']);
            $this->logoutMessage();
            return $this->loginForm();
        }
    }
   /* public function retrieveFormPostInfoIfLogoutButtonClicked() {
        //variablerna måste kommas ihåg om sidan uppdateras
        if(isset($_POST["logoutbutton"])){
            var_dump('d');
            return true;
        }
    }*/


    function doesCookieExist() {
        if (isset($_COOKIE["Cookie"])){
            return true;
        }
    }
    function setCookie($pass) {
        if(isset($_POST['loginbutton'])){
                // Checks if checkbox is checked
            if(isset($_POST['checked']) && $_POST['checked'] == 'on') {
                $this->loginWithCookieMessage();
                // Set a cookie that expires in 24 hours
                $cookieExpirationTime = time()+300;
                setcookie("Cookie",$pass, $cookieExpirationTime, "/");
            }
        }
    }

    public function loginWithoutCookieMessage() {
        $this->message = "success";
    }
    public function loginWithCookieMessage() {
        $this->message = "Login With Cookie, You will be remembered";
    }
    public function logoutMessage() {
        $this->message = "You logged out successfully";
    }
    public function lognWithCookie() {
        $this->message = "You logged in with cookie";
    }

    function getUserName() {
        return $this->userName;
    }
    function getPassword() {
        return $this->password;
    }
}