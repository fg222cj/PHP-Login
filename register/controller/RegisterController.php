<?php
require_once('./register/view/RegisterView.php');
require_once('./register/model/RegisterModel.php');
require_once('./exceptions/ValidationException.php');

class RegisterController {
	private $view;
	private $model;
	
	public static $registrationSuccess = "RegistrationSuccessful";
	
	public function __construct() {
		$this->model = new RegisterModel();
		$this->view = new RegisterView($this->model);
	}
	
	public function registerUser() {
		if($this->view->registrationAttempt()) {
			try {
				$this->model->registerUser($this->view->getUsername(), $this->view->getFirstPassword(), $this->view->getSecondPassword());
				return self::$registrationSuccess;
			}
			catch(ValidationException $e) {
				foreach($e->getMessages() as $errorMessage) {
					$this->view->addErrorMessage($errorMessage);
				}
				return $this->view->registerForm();
			}
			catch(Exception $e) {
				$this->view->addErrorMessage($e->getMessage());
				return $this->view->registerForm();
			}
		} else {
			return $this->view->registerForm();
		}
	}
}


?>