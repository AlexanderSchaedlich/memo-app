<?php  
	class LoginController extends AbstractController {
		private $authorsRepository;

		public function __construct($authorsRepository) {
			$this->authorsRepository = $authorsRepository;
		}
		// render the view
		public function prepareLogin() {
			$emailError = "";
			$passwordError = "";
		    // check the provided data and log in
		    if ($_POST) {
		        $emailAddress = trim($_POST["email_address"]);
		        $password = trim($_POST["password"]);
		        // check the input for correspondense with the database entries
		        $author = $this->authorsRepository->getAuthorByEmailAddress($emailAddress);
	            if (empty($author)) {
	            	$emailError = "Falsche Email-Adresse.";
	            } elseif ($author["active"] == "0") {
	            	$emailError = "Ihr Konto ist nicht aktiviert. Bitte bestätigen Sie Ihre Email-Adresse.";
	            } elseif (! password_verify($password, $author["password"])) {
	            	$passwordError = "Falsches Passwort.";
	            } else {
	            	$_SESSION["id"] = $author["id"];
	            	
	            	if ($author["role"] == "user") {
                        $_SESSION["admin"] = false;
                    } else {
                        $_SESSION["admin"] = true;
                    }
                    // go to open memos page
                    header("Location: openmemos");
	            }
		    }

			$this->render(
				// file name
				"login", 
				// variables to pass
				[
					"emailError" => $emailError,
					"passwordError" => $passwordError
				]
			);
		}
	}
?>