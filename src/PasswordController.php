<?php  
    include "composer/vendor/autoload.php";

    // give aliases to namespaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class PasswordController extends AbstractController {
		private $authorsRepository;
		private $emailService;

		public function __construct($authorsRepository, $emailService) {
			$this->authorsRepository = $authorsRepository;
			$this->emailService = $emailService;
		}

		public function forgotPassword() {
			$isRegistered = null;
			$emailWasSent = null;

			if ($_POST) {
				$emailAddress = trim($_POST["email_address"]);
				// check if there is a registered author which has this email address
				if ($isRegistered = ! empty($author = $this->authorsRepository->getAuthorByEmailAddress($emailAddress))) {
					$_SESSION["email_address"] = $author["email_address"];
					// generate a key
					$key = $this->generateRandomString(10);
					// hash the key
                	$_SESSION["reset_password_key"] = $hashedKey = 
                	password_hash($key, PASSWORD_DEFAULT);
					// send an email with a password reset link to the user
					$fullName = $author["first_name"] . " " . $author["last_name"];
            		$emailText = "
						<html>
							Guten Tag,<br>
							<br>
							Sie können Ihr Passwort nun zurücksetzen. Bitte klicken Sie dazu auf den folgenden Link:
							<h3>
								<a href='https://ixtest07-ebkgakhg.webpreview.at/index.php/resetpassword?key={$hashedKey}'>Passwort zurücksetzen</a>
							</h3>
							<br>
							Mit freundlichen Grüßen,<br>
							Ihr Smiling Memos Team
						</html> 
					";
					$emailWasSent = $this->emailService->sendEmail($emailAddress, $fullName, "Smiling Memos: Passwort zurücksetzen", $emailText);
				}
			}

			$this->render(
				// file name
				"forgotPassword", 
				// variables
				[
					"isRegistered" => $isRegistered,
					"emailWasSent" => $emailWasSent
				]
			);
		}

	    public function resetPassword() {
	    	$isLongEnough = null;
	    	$containsSpecialCharacters = null;
	    	$passwordWasUpdated = null;
	    	$author = null;

	    	// if the user is redirected to this page from his email
	    	if (! $_POST) {
	    		if (! $_GET["key"] 
	    			|| ! $_GET["key"] == $_SESSION["reset_password_key"]) {
	    			header("Location: login");
	    		}
	    	}
	    	
    		if ($_POST) {
    			$password = trim($_POST["password"]);

    			if ($isLongEnough = strlen($password) >= 6) {
    				if ($containsSpecialCharacters = preg_match("/[\'^£$%&*()}{@#~?!.:;§€\/°><>,|=_+¬-]/", $password)) {
    					// hash the password
    					$password = password_hash($password, PASSWORD_DEFAULT);

    					$author = $this->authorsRepository->getAuthorByEmailAddress($_SESSION["email_address"]);
    					
	                    if (! empty($author)) {
	                    	if ($passwordWasUpdated = $this->authorsRepository->updatePassword($_SESSION["email_address"], $password)) {
	                    		// unset the reset password key and email address to prevent malicious users from exploiting it
								unset($_SESSION["reset_password_key"]);
					        	unset($_SESSION["email_address"]);
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
	                }
    			}
    		}

	    	$this->render(
				// file name
				"resetPassword", 
				// variables
				[
					"isLongEnough" => $isLongEnough,
					"containsSpecialCharacters" => $containsSpecialCharacters,
					"author" => $author,
					"passwordWasUpdated" => $passwordWasUpdated
				]
			);
	    }
	}
?>