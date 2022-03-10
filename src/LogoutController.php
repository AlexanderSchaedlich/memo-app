<?php  
	class LogoutController extends AbstractController {
		private $connection;

        public function __construct($dbConnection) {
            $this->connection = $dbConnection;
        }

		public function logOut() {
			// close the database connection
			$this->connection->close();
			// unset session variables
		    session_unset();
		    // destroy session data
		    session_destroy();
		    header("Location: login");
		}
	}
?>