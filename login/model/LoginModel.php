<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:25
 */
require_once("./helpers/FileHandling.php");
 
class ModelClass {
    private $errorMSG;
    public $temporaryPassword;
    private $cookieExpirationTime;
	
	private $usersFilePath = "./Users.txt";						// I denna fil finns alla användare och deras (krypterade) lösenord sparade.
	private $savedCredentialsFilePath = "./TempPasswords.txt";	// I denna fil lagras användare och temporära lösenord när användaren vill fortsätta vara inloggad.

    public function __construct() {
    }

    //checks if users login input is correct
    public function userInputOK($userName,$password) {

        if($userName === "") {
        	$this->errorMSG = "Missing username";
			return false;
        }
        if($password === "") {
        	$this->errorMSG = "Missing password";
			return false;
        }
            
		$password = md5($password);
		
		$usersFile = file($this->usersFilePath);
		foreach($usersFile as $row) {
			$user = explode(';', $row);
			//if it is correct, returns true
	        if($userName === $user[0] && $password === $user[1]){
	        	$_SESSION['user'] = $user[0];
	            return true;
	        }
		}
		$this->errorMSG = "Wrong username and/or password";
		return false;

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
	//creates temporary unique password based on the users real password and the current time
	function createTemporaryPassword($password) {
		$this->temporaryPassword = md5($password . time());
	}

    //stores username, temporary password and expirationtime into textfile
    public function saveCredentialsOnServer($username, $password, $expirationTime) {
			$savedCredentials = $username . ";" . $password . ";" . $expirationTime . ";";
			FileHandling::writeLineToFile($this->savedCredentialsFilePath, $savedCredentials);
		}
    //checks if cookie is manipulated
    function ifCookieIsNotManipulated($userCookieValue, $passwordCookieValue) {
        //reads from file where expirationtime is stored
        $tempCredentials = file($this->savedCredentialsFilePath);
		foreach($tempCredentials as $row) {
			$credentials = explode(';', $row);
			//checks if the cookies values checks out
        	if($userCookieValue == $credentials[0] && $passwordCookieValue == $credentials[1]) {
	            //if it does, the it checks if the time stored in cookie is more than the current time
	            //if the stored time is set on a moment that is futher on than the current time, it has been manipulated
	            if($credentials[2] > time()){
	            	$_SESSION['user'] = $credentials[0];
	                return true;
	            }
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
    public function getTemporaryPassword() {
        return $this->temporaryPassword;
    }
	
	public function getLoggedInUsername() {
		return $_SESSION['user'];
	}
	
	public function getNewestUser() {
		// http://stackoverflow.com/questions/1062716/php-returning-the-last-line-in-a-file
		$lastRow = `tail -n 1 $this->usersFilePath`;
		$user = explode(';', $lastRow);
		return $user[0];
	}
}