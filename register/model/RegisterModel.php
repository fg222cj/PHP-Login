<?php
require_once("./helpers/FileHandling.php");

class RegisterModel {
	private $usersFilePath = "./Users.txt";			// I denna fil finns alla användare och deras (krypterade) lösenord sparade.
	private $safeUsername = "";
	
	public function registerUser($username, $firstPassword, $secondPassword) {
		$errorMessage = array();	// Lagrar eventuella felmeddelanden för senare utskrift.
		
		$this->safeUsername = filter_var($username, FILTER_SANITIZE_STRING);
		
		try {
			$this->validateUsername($this->safeUsername);
		}
		catch(Exception $e){
			$errorMessage[] = $e->getMessage();
		}
		
		try {
			$this->validatePasswords($firstPassword, $secondPassword);
		}
		catch(Exception $e) {
			$errorMessage[] = $e->getMessage();
		}
		
		if(count($errorMessage) > 0) {
			throw new ValidationException($errorMessage);
		}
		
		if($this->isUsernameAvailable($this->safeUsername) && $this->isUsernameSafe($username)) {
			$this->addUser($this->safeUsername, $firstPassword);
		}

	}
	
	private function addUser($username, $password) {
		$row = $username . ";" . md5($password) . ";";
		FileHandling::writeLineToFile($this->usersFilePath, $row);
	}
	
	private function isUsernameSafe($username) {
		if($username !== $this->safeUsername) {
			throw new Exception("Användarnamnet innehåller ogiltiga tecken");
		}
		
		return true;
	}
	
	// Kolla om användarnamnet är upptaget, i så fall kastas ett undantag. Annars true.
	private function isUsernameAvailable($username) {
		$existingUsers = file($this->usersFilePath);
		
		foreach($existingUsers as $row) {
			$user = explode(';', $row);
			
			if(strtolower($username) == strtolower($user[0])) {
				throw new Exception("Användarnamnet är redan upptaget");
			}
		}
		
		return true;
	}
	
	private function validateUsername($username) {
		if(!isset($username) || strlen($username) < 3) {
			throw new Exception("Användarnamnet har för få tecken. Minst 3 tecken");
		}
	}
	
	private function validatePasswords($firstPassword, $secondPassword) {
		if(!isset($firstPassword) || !isset($secondPassword) || strlen($firstPassword) < 6) {
			throw new Exception("Lösenorden har för få tecken. Minst 6 tecken");
		}
		
		if($firstPassword !== $secondPassword) {
			throw new Exception("Lösenorden matchar inte.");
		}
	}
	
	// Getters
	public function getSafeUsername() {
		return $this->safeUsername;
	}
	
}

?>