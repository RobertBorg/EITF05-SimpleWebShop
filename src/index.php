<?php 
	include_once "./model/database.php";
	include_once "./model/user.php";
	include_once "./model/product.php";
	function getUniqueCode($length = "") {
		$code = md5(uniqid(rand(), true));
		if ($length != "") return substr($code, 0, $length);
		else return $code;
	}
	function isCSRFGuardOk() {
		return isset($_SESSION['CSRFGuard']) && $_POST['CSRFGuard'] == $_SESSION['CSRFGuard'];
	}
	session_start();
	if(!isset($_SESSION['CSRFGuard'])){
		$_SESSION['CSRFGuard'] = getUniqueCode(16);
	}
	//Allowed pre login
	switch ($_GET['method']){
		case "signUp":
			$inputOk = true;
			$inputOk = $inputOk && isset($_POST['userName']);
			$inputOk = $inputOk && isset($_POST['password']);
			$inputOk = $inputOk && isset($_POST['password_reapeat']);
			$inputOk = $inputOk && isset($_POST['home_address']);
			$inputOk = $inputOk && isCSRFGuardOk();
			if($inputOk){
				//XXX code create new user
				include ("./view/SignIn.php");
			} else {
				include ("./view/SignUp.php");
			}
			exit;
			break;
		case "signIn":
			$inputOk = true;
			$inputOk = $inputOk && isset($_POST['userName']);
			$inputOk = $inputOk && isset($_POST['password']);
			$inputOk = $inputOk && isCSRFGuardOk();
			if($inputOk){
				//XXX code try to login
				include ("./view/SignIn.php");
			} else {
				include ("./view/SignIn.php");
			}
			exit;
			break;
	}
	if(!isset($_SESSION['user'])){
		session_destroy();
		session_start();
		include("./view/SignIn.php");
		exit;
	}
	//Allowed mothods post login
	switch ($_GET['method']){
		case "signOut":
			break;
		case "addToCart":
			break;
		case "checkOut":
			break;
		case "confirmCheckOut":
			break;
		case "removeFromCart":
			break;
	}

?>
