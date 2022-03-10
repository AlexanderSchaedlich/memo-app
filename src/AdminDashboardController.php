<?php  
	class AdminDashboardController extends AbstractController {
		private $authorsRepository;

		public function __construct($authorsRepository) {
			$this->authorsRepository = $authorsRepository;
		}

		public function prepareAdminDashboard() {
			$this->checkAdmin();
			$authors = $this->authorsRepository->getAuthors();
			$this->render(
				// file name
				"adminDashboard", 
				// variables
				[
					"authors" => $authors
				]
			);
		}
	}
?>