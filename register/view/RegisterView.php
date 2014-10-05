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
        $weekDay = ucfirst(utf8_encode(strftime("%A")));	// Veckodag. ucfirst() sätter stor bokstav i början av veckodagen, ex: måndag blir Måndag. utf8_encode() gör att åäö funkar.
		$date = strftime("%#d");							// Datum. kommer sannolikt behöva ändras i en linux-miljö.
		$month = ucfirst(strftime("%B"));					// Månad. behöver inte utf8_encode eftersom inga svenska månadsnamn innehåller åäö.
		$year = strftime("%Y");								// År.
		$time = strftime("%H:%M:%S");						// Tid.
		
		return $weekDay . ", den " . $date . " " . $month . " år " . $year . ". Klockan är [" . $time . "]";
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