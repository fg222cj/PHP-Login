<?php

class NavigationView {
	public static $registerUser = "registerUser";
	public static $loginUser = "loginUser";
	
	public static function getAction() {
		if(isset($_GET['register'])) {
			return self::$registerUser;
		}
		
		return self::$loginUser;
	}
}


?>