<?php  
	session_start();

	require "init.php";

	// set the routes, controllers and methods
	$routes = [
		"/register" => [
			"controller" => "RegisterController",
			"method" => "prepareRegistration"
		],
		"/activateaccount" => [
			"controller" => "RegisterController",
			"method" => "activateAccount"
		],
		"/login" => [
			"controller" => "LoginController",
			"method" => "prepareLogin"
		],
		"/logout" => [
			"controller" => "LogoutController",
			"method" => "logOut"
		],
		"/forgotpassword" => [
			"controller" => "PasswordController",
			"method" => "forgotPassword"
		],
		"/resetpassword" => [
			"controller" => "PasswordController",
			"method" => "resetPassword"
		],
		"/openmemos" => [
			"controller" => "MemosController",
			"method" => "prepareOpenMemos"
		],
		"/mymemos" => [
			"controller" => "MemosController",
			"method" => "prepareMyMemos"
		],
		"/account" => [
			"controller" => "AccountController",
			"method" => "prepareAccount"
		],
		"/admindashboard" => [
			"controller" => "AdminDashboardController",
			"method" => "prepareAdminDashboard"
		],
		"/ajax" => [
			"controller" => "AjaxService",
			"method" => "makeRequest"
		]
	];
	// $_SERVER["PATH_INFO"] is a string that comes after the file name; it doen't include queries
	// if there is no path info
	if (! isset($_SERVER["PATH_INFO"])) {
		// render the home page view
		$home = $container->createInstance("HomeController");
		$home->prepareHome();
	} 
	// if the path info outputs a string
	else {
		// render the respective view
		$route = $routes[$_SERVER["PATH_INFO"]];
		$controller = $container->createInstance($route["controller"]);
		$method = $route["method"];
		$controller->$method();
	}
?>