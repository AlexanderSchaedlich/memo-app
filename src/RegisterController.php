<?php   
    class RegisterController extends AbstractController {
        private $authorsRepository;
        private $emailService;

        public function __construct($authorsRepository, $emailService) {
            $this->authorsRepository = $authorsRepository;
            $this->emailService = $emailService;
        }

        public function prepareRegistration() {
            $error = false;
            $emailError = "";
            $passwordError = "";
            $errorMessage = "";
            $emailWasSent = null;

            if ($_POST) {
                $firstName = trim($_POST["first_name"]);
                $lastName = trim($_POST["last_name"]);
                $emailAddress = trim($_POST["email_address"]);
                $password = trim($_POST["password"]);

                // check if the input is valid
                if (! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                    $error = true;
                    $emailError = "Bitte geben Sie eine gültige Email-Adresse ein.";
                } else {
                    $emailAddressExists = $this->authorsRepository->emailAddressExists($emailAddress);
                    if (gettype($emailAddressExists) == gettype("error") 
                        && $emailAddressExists == "error") {
                        $error = true;
                        $emailError = "error";
                    } elseif ($emailAddressExists) {
                        $error = true;
                        $emailError = "Es ist bereits ein Benutzer mit dieser Email-Adresse registriert.";
                    }
                }

                if (strlen($password) < 6) {
                    $error = true;
                    $passwordError = "Das Passwort muss mindestens 6 Zeichen lang sein.";
                } elseif (! $this->containsLetters($password)) {
                    $error = true;
                    $passwordError = "Das Passwort muss mindestens einen Buchstaben enthalten.";
                } elseif (! preg_match("/[\'^£$%&*()}{@#~?!.:;§€\/°><>,|=_+¬-]/", $password)) {
                    $error = true;
                    $passwordError = "Das Passwort muss mindestens ein Sonderzeichen enthalten.";
                } elseif ($this->equalsKnown($password)) {
                    $error = true;
                    $passwordError = "Dieses Passwort gehört zu den am häufigsten verwendeten Passwörtern. Bitte wählen Sie ein anderes.";
                }

                // hash the password
                $password = password_hash($password, PASSWORD_DEFAULT);

                // if there is no error
                if (! $error) {
                    // generate a key
                    $key = $this->generateRandomString(255);
                    // pre-register the user: 
                    // don't set the "active" field to true
                    if (! $this->authorsRepository->preRegister($firstName, $lastName, $emailAddress, $password, $key)) {
                        $errorMessage = "Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.";
                    } else {
                        // send an email with a register link to the user
                        $fullName = $firstName . " " . $lastName;
                        $subject = "Smiling Memos: Email-Adresse bestätigen";
                        $emailText = "
                            <html>
                                Guten Tag,<br>
                                <br>
                                um Ihre Email-Adresse zu bestätigen und die Registrierung abzuschließen, klicken Sie bitte auf den folgenden Link:
                                <h3>
                                    <a href='http://memo-app.web90.s274.goserver.host/index.php/activateaccount?key={$key}'>Email-Adresse bestätigen</a>
                                </h3>
                                <br>
                                Mit freundlichen Grüßen,<br>
                                Ihr Smiling Memos Team
                            </html> 
                        ";
                        $emailWasSent = $this->emailService->sendEmail($emailAddress, $fullName, $subject, $emailText);
                    } 
                }
            }

            // render the view
            $this->render(
                // name of the file that should be rendered
                "register", 
                // variables as key-value pairs in an associative
                [
                    "emailError" => $emailError,
                    "passwordError" => $passwordError,
                    "errorMessage" => $errorMessage, 
                    "emailWasSent" => $emailWasSent
                ]
            );
        }

        public function activateAccount() {
            // check if the user is redirected to this page from his email 
            // and has the correct key
            if (! $_GET["key"]
                || $_GET["key"] == "") {
                header("Location: login");
            } else {
                $author = $this->authorsRepository->getAuthorByKey($_GET["key"]);
                if (empty($author)) {
                    header("Location: login");
                } else {
                    // activate the account
                    if ($this->authorsRepository->activateAccount($author["id"])) {
                        // log in the author
                        $_SESSION["id"] = $author["id"];
                        $_SESSION["admin"] = false;
                        // go to the open memos page
                        header("Location: openmemos");
                    }
                }
            }
        }
    }
?>