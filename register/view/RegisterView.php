<?php

class RegisterView {
	private $errorMSG = "";
	private $message;
	
	private $model;
	
	public function __construct(RegisterModel $model) {
		$this->model = $model;
	}
	
	public function registerForm() {
		$errorMSG = $this->errorMSG;
        $message = $this->message;
		$populatedUsername = "";
		if($this->model->getSafeUsername() != "") {
			$populatedUsername = "value=" . $this->model->getSafeUsername();
		}
		
        $ret = "
        <h1>Login Application</h1>
        <p><a href='?'>Tillbaka</a></p>
        <h2>Ej Inloggad, Registrerar användare</h2>
        <form method=post enctype=multipart/form-data action=?register>
            <fieldset>
                <legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>
                <p>$message</p>
        		<p>$errorMSG</p>
                <label for=newusernameID>Namn :</label>
                <input type=text size=20 name=newusername id=newusernameID $populatedUsername>
                <br />
                
                <label for=firstPasswordID>Lösenord  :</label>
                <input type=password size=20  name=firstPassword id=firstPasswordID>
                <br />
                
                <label for=secondPasswordID>Repetera Lösenord  :</label>
                <input type=password size=20  name=secondPassword id=secondPasswordID>
                <br />
                
                <label for=sendID>Skicka :</label>
                <input type=submit name=registerbutton id=sendID value=Registrera>
            </fieldset>
            <p>" . $this->Time() . "</p>
        </form>
        ";
        return $ret;
	}
	
	//TIme() set the local time and creates a string for the Forms to print the current time
    public function Time() {
        setlocale(LC_ALL, "sv_SE");
        return $this->time = (strftime("%A, den %d %B år %Y. Klockan är [%X]"));
    }
    
    public function registrationAttempt() {
    	return isset($_POST['newusername']);
    }
    
    public function addErrorMessage($errorMessage) {
    	$this->errorMSG .= "<p>" . $errorMessage . "</p>";
    }
    
    // Getters
    public function getUsername() {
    	if(isset($_POST['newusername'])) {
    		return $_POST['newusername'];
    	}
    }
    
    public function getFirstPassword() {
    	if(isset($_POST['firstPassword'])) {
    		return $_POST['firstPassword'];
    	}
    }
    
    public function getSecondPassword() {
    	if(isset($_POST['secondPassword'])) {
    		return $_POST['secondPassword'];
    	}
    }
}


?>