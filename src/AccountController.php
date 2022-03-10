<?php  
	class AccountController extends AbstractController {
		private $authorsRepository;

		public function __construct($authorsRepository) {
			$this->authorsRepository = $authorsRepository;
		}

		public function prepareAccount() {
			$this->checkLogin();
			$author = $this->authorsRepository->getAuthor($_SESSION["id"]);
            $error = false;
            $emailError = "";
            $passwordError = "";
            $emailAddressExists = null;
            $updatedAuthor = null;

            if ($_POST) {
                $id = $_SESSION["id"];
                $firstName = trim($_POST["first_name"]);
                $lastName = trim($_POST["last_name"]);
                $emailAddress = trim($_POST["email_address"]);
                $password = trim($_POST["password"]);

                if ($_SESSION["admin"]) {
                	$role = "admin";
                } else {
                	$role = "user";
                }

                // check if the input is valid
                if (! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                    $error = true;
                    $emailError = "Bitte geben Sie eine gültige Email-Adresse ein.";
                } else {
                	// check if the user provided a new email address
                    $emailAddressBelongsToId = $this->authorsRepository->emailAddressBelongsToId($emailAddress, $id);

                    if (gettype($emailAddressBelongsToId) == gettype("error") 
                        && $emailAddressBelongsToId == "error") {
                        $error = true;
                    } elseif (! $emailAddressBelongsToId) {
                		// check if the new email address already exists
                        $emailAddressExists = $this->authorsRepository->emailAddressExists($emailAddress);
                		if (
                            (
                                gettype($emailAddressExists) == gettype("error") 
                                && $emailAddressExists == "error"
                            ) 
                            || $emailAddressExists
                        ) {
	                        $error = true;
	                    }
                	}
                }

                if ($password != "") {
                	if (strlen($password) < 6) {
	                    $error = true;
	                    $passwordError = "Das Passwort muss mindestens 6 Zeichen lang sein.";
	                } elseif (! $this->containsSpecialCharacters($password)) {
	                    $error = true;
	                    $passwordError = "Das Passwort muss mindestens ein Sonderzeichen enthalten.";
	                }

	                // hash the password
                	$password = password_hash($password, PASSWORD_DEFAULT);
                }

                if (! $error) {
                    // update the database
                    if ($password != "") {
                    	if ($updatedAuthor = $this->authorsRepository->updateAuthorAll($id, $firstName, $lastName, $emailAddress, $password, $role)) {
                            $author = $this->authorsRepository->getAuthor($id);
                        }
                    } else {
                    	if ($updatedAuthor = $this->authorsRepository->updateAuthorUser($id, $firstName, $lastName, $emailAddress)) {
                            $author = $this->authorsRepository->getAuthor($id);
                        }
                    }
                }
            }

			$this->render(
				// file name
				"account", 
				// variables
				[
					"author" => $author,
                    "emailAddressExists" => $emailAddressExists, 
					"passwordError" => $passwordError, 
					"updatedAuthor" => $updatedAuthor
				]
			);
		}
	}
?>