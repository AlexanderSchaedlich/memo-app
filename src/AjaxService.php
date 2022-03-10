<?php 
	class AjaxService extends AbstractController {
		private $authorsRepository;
		private $memosRepository;

		public function __construct($authorsRepository, $memosRepository) {
			$this->authorsRepository = $authorsRepository;
			$this->memosRepository = $memosRepository;
		}

		public function makeRequest() {
			if ($_POST) {
				switch ($_POST["action"]) {
					case "create_memo":
						$fkAuthor = $_SESSION["id"];
						$title = trim(($_POST["title"]));
						$text = trim(($_POST["text"]));
						$visibility = trim(($_POST["visibility"]));
						
						// true on success and false on failure
						if ($this->memosRepository->createMemo($fkAuthor, $title, $text, $visibility)) {
							// get the recently created memo
							$lastMemo = $this->memosRepository->getAuthorsLastMemo($fkAuthor);
    						echo json_encode($lastMemo);
						} else {
							echo json_encode([]);
						}

						break;

					case "update_memo":
						$fkAuthor = $_SESSION["id"];
						$date = trim(($_POST["date"]));
						$title = trim(($_POST["title"]));
						$text = trim(($_POST["text"]));
						$visibility = trim(($_POST["visibility"]));

						// true on success and false on failure
						if ($this->memosRepository->updateMemo($fkAuthor, $date, $title, $text, $visibility)) {
							// get the updated memo
							$updatedMemo = $this->memosRepository->getMemoByAuthorDate($fkAuthor, $date);
							// try to set locale to german and use utf-8
    						setlocale(LC_ALL, "de.utf-8", "de_DE@euro", "de_DE", "de", "deu", "ge", "german", "germany", "0");
    						// create a nice date format
    						$updatedMemo["styled_date"] = strftime("%A, den %d. %B %Y", strtotime($updatedMemo["date"]));
    						echo json_encode($updatedMemo);
						} else {
							echo json_encode([]);
						}

						break;

					case "delete_memo":
						$fkAuthor = $_SESSION["id"];
						$date = trim(($_POST["date"]));

						// true on success and false on failure
						echo $this->memosRepository->deleteMemo($fkAuthor, $date);

						break;

					case "delete_memos_by_author":
						// true on success and false on failure
						echo $this->memosRepository->deleteMemosByAuthor($_SESSION["id"]);

						break;

					case "update_author":
						$id = trim(($_POST["id"]));
						$firstName = trim(($_POST["first_name"]));
						$lastName = trim(($_POST["last_name"]));
						// $emailAddress = trim(($_POST["email_address"]));
						$role = trim(($_POST["role"]));
						
						// true on success and false on failure
						if ($this->authorsRepository->updateAuthor($id, $firstName, $lastName, $role)) {
							// get the recently updated author
							$updatedAuthor = $this->authorsRepository->getAuthor($id);
    						echo json_encode($updatedAuthor);
						} else {
							echo json_encode([]);
						}

						break;

					case "delete_author":
						// true on success and false on failure
						echo $this->authorsRepository->deleteAuthor($_SESSION["id"]);

						break;

					case "generate_password":
						echo $this->createRandomString(10);
						break;
				}
				
			}
		}
	}
?>