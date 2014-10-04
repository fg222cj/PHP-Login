<?php

class ValidationException extends Exception {
	private $messages;
	
	public function __construct($messages) {
		$this->messages = $messages;
	}
	
	public function getMessages() {
		return $this->messages;
	}
}

?>