<?php  
	class HomeController extends AbstractController {
		// render the view
		public function prepareHome(){
			$home = "test";
			$this->render(
				"home", 
				[
					"home" => $home
				]
			);
		}
	}
?>