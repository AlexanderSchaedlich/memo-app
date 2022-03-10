<?php  
	class MemosController extends AbstractController {
		private $memosRepository;

		public function __construct($memosRepository) {
			$this->memosRepository = $memosRepository;
		}

		public function prepareOpenMemos() {
			$arrayOfStrings = [
                "abcdefghijklmnopqrstuvwxyz",
                "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
                "0123456789",
                "!#$%&()*+,-./:;=?[]{}~|@_^" // many characters for high entropy
            ];
			$test = $this->generateString($arrayOfStrings, 4, true);
			$this->checkLogin();
			$openMemos = $this->memosRepository->getOpenMemos();
			$this->render(
				// file name
				"openMemos", 
				// variables
				[
					"test" => $test,
					"openMemos" => $openMemos
				]
			);
		}

		public function prepareMyMemos() {
			$this->checkLogin();

			$myMemos = $this->memosRepository->getMemosByAuthor($_SESSION["id"]);

			$this->render(
				// file name
				"myMemos", 
				// variables
				[
					"myMemos" => $myMemos
				]
			);
		}
	}
?>