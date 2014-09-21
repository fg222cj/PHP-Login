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
    private $cookieExpiration;
    private $userCookieValue;
   //initiates Time()
    function __construct() {
        $this->Time();
    }
    //function to check if page is refreshed(not used)
    public function PageIsRefreshed(){
        if(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'){
        return true;
        }
    }
    //TIme() set the local time and creates a string for the Forms to print the current time
    public function Time() {
        setlocale(LC_ALL, "sv_SE");
        $this->time = (strftime("%A, den %d %B år %Y. Klockan är [%X]"));
    }
    //Recieves the error message sent from controller<-Model
    public function errorMSGHandler($errorMSG) {
        $this->errorMSG = $errorMSG;
    }
    //the form presented when user wants to login
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
    //the form presented when user is logged in
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
    //check if any posts are made and stores values into variables
    public function retrieveFormPostInfoIfLoginButtonClicked() {
        if(isset($_POST["loginbutton"])){
            $this->userName = $_POST["userName"];
            $this->password = $_POST["password"];
            return true;
        }
    }
    //if the user clicked logoutbutton it unsets all sessions and cookies and logs user out
    function ifUserClickedLogoutButton() {
        if (isset($_POST["logoutbutton"])) {
            setcookie ("Cookie", "", time() - 300);
            unset($_SESSION['LOGIN']);
            unset($_SESSION['USER']);
            $this->logoutMessage();
            return $this->loginForm();
        }
    }



    // function check if certrain cookie exists
    function doesCookieExist() {
        if (isset($_COOKIE["Cookie"])){
            return true;
        }
    }
    //creates a cookie
    function setCookie($pass) {
        //check if loginbutton has been clicked
        if(isset($_POST['loginbutton'])){
            // Checks if checkbox is checked
            if(isset($_POST['checked']) && $_POST['checked'] == 'on') {
                //renders a login message for the user
                $this->loginWithCookieMessage();
                //stores the amount of time cookie should be valid
                $this->cookieExpiration = time()+60;
                // Set a cookie that expires in a centrain amount of time
                setcookie("Cookie",$pass, $this->cookieExpiration, "/");
            }
        }
    }
    //destroys cookie
    function unsetCookie() {
        setcookie ("Cookie", "", time() - 3600);
    }
    //deeeeestroys session
    function unsetSession() {
        unset($_SESSION['LOGIN']);
        unset($_SESSION['USER']);
    }

    //stores the value of the cookie, in this case the string that works as a password
    function getCookieValues() {
        $this->userCookieValue = $_COOKIE["Cookie"];
    }


    // these functions delivers either login fail or success message depending on UC
    public function loginWithoutCookieMessage() {
        $this->message = "successfully logged in";
    }
    public function loginWithCookieMessage() {
        $this->message = "Login With Cookie, you will be remembered";
    }
    public function logoutMessage() {
        $this->message = "You logged out successfully";
    }
    public function loginWithCookie() {
        $this->message = "You logged in with cookie";
    }
    public function logoutFaultyCookie() {
        $this->message = "Cookie info seem sketchy out";
    }


    //Getters
    function getUserName() {
        return $this->userName;
    }
    function getPassword() {
        return $this->password;
    }
    function getCookieExpiration() {
        return $this->cookieExpiration;
    }
    function getUserCookieValue() {
        return $this->userCookieValue;
    }
}