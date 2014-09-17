<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:32
 */

class ViewClass {
    private $time;

    function __construct() {
        $this->Time();
    }
    public function ifPageIsRefreshed(){
        if(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0')
            return true;
    }
    function Time() {
        setlocale(LC_ALL, "sv_SE");
        $this->time = (strftime("%A, den %d %B år %Y. Klockan är [%X]"));
    }

    function loginForm() {
        $timeVariable = $this->time;

        $ret = "
        <h1>Login Application</h1>
        <form method=post enctype=multipart/form-data action=?loggedIn>
            <fieldset>
            <p></p>
            <p></p>
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
        $timeVariable = $this->time;
        $ret = "
       <h1>Logged in to Application</h1>
        <form method=get enctype=multipart/form-data action=?login>
            <fieldset>
                <legend>You are now signed in as Admin</legend>
                <p>$this->loginSuccessful</p>
                    <input type=submit name=logoutbutton>
            </fieldset>
            <p>$timeVariable</p>
        </form>
        ";
        return $ret;
    }

}