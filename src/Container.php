<?php  
	class Container {
		public $connection;
		private $instructions = [];
		private $instances = [];

		public function __construct($dbConnection) {
			// use the database connection
			$this->connection = $dbConnection;
			// set the keywords for the controllers instantiation
			$this->instructions = [
				"HomeController" => function() {
					return new HomeController();
				},
				"RegisterController" => function() {
					return new RegisterController(
						$this->createInstance("AuthorsRepository"), 
						$this->createInstance("EmailService")
					);
				},
				"LoginController" => function() {
					return new LoginController(
						$this->createInstance("AuthorsRepository")
					);
				},
				"LogoutController" => function() {
					return new LogoutController($this->connection);
				},
				"PasswordController" => function() {
					return new PasswordController(
						$this->createInstance("AuthorsRepository"), 
						$this->createInstance("EmailService")
					);
				},
				"MemosController" => function() {
					return new MemosController(
						$this->createInstance("MemosRepository")
					);
				},
				"AccountController" => function() {
					return new AccountController(
						$this->createInstance("AuthorsRepository")
					);
				},
				"AdminDashboardController" => function() {
					return new AdminDashboardController(
						$this->createInstance("AuthorsRepository")
					);
				},
				"AjaxService" => function() {
					return new AjaxService(
						$this->createInstance("AuthorsRepository"), 
						$this->createInstance("MemosRepository")
					);
				},
				"EmailService" => function() {
					return new EmailService();
				},
				"AuthorsRepository" => function() {
					return new AuthorsRepository($this->connection);
				},
				"MemosRepository" => function() {
					return new MemosRepository($this->connection);
				}
			];
		}

		public function createInstance($name) {
			// if this instance doesn't exist, create it
			if (empty($this->instances[$name])) {
				$this->instance[$name] = $this->instructions[$name]();
			} 
			// return the instance
			return $this->instance[$name];
		}
	}
?>