<?php
require_once('./navigation/view/NavigationView.php');
require_once('./login/controller/LoginController.php');
require_once('./register/controller/RegisterController.php');

class NavigationController {
	private static $registrationSuccess = true;
	
	public function doNavigation() {
		switch(NavigationView::getAction()) {
			case NavigationView::$registerUser:
				$controller = new RegisterController();
				$result = $controller->registerUser();
				
				if ($result == RegisterController::$registrationSuccess) {
					$controller = new LoginController(self::$registrationSuccess);
					return $controller->formControll();
				} else {
					return $result;
				}
				break;
				
			case NavigationView::$loginUser:
			default:
				$controller = new LoginController();
				return $controller->formControll();
				break;
		}
	}
}



?>