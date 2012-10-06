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
				$size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
   				$iv = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
				$user = new User($_POST['userName'],sha1($_POST['password'] + $iv),$iv,$_POST['home_address']);
				$db = new Database();
				if($db->create($user, USER)) {
					include ("./view/SignIn.php");
				}else {
					include ("./view/SignUp.php");
				}
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
				$db = new Database();
				$user = $db->read($_POST['userName'], USER);
				if($user->isPasswordCorrect($_POST['password'])) {
					$_SESSION['user'] = $_POST['userName'];
					include ("./view/Shop.php");	
				} else {
					include ("./view/SignIn.php");
				}
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
			session_destroy();
			session_start();
			include "./view/SignIn.php";
			break;
		case "addToCart":
			$inputOk = true;
			$inputOk = $inputOk && isset($_POST['product_id']);
			$inputOk = $inputOk && isCSRFGuardOk();
			if($inputOk){
				if(!isset($_SESSION['cart'])){
					$_SESSION['cart'] = array();
				}
				if(!isset($_SESSION['cart'][$_POST['product_id']])){
					$_SESSION['cart'][$_POST['product_id']] = 1;
				} else {
					$_SESSION['cart'][$_POST['product_id']]++;
				}
				include "./view/Shop.php";
			} else {
				//XXX add badboy code?
				include "./view/Shop.php";
			}
			break;
		case "checkOut":
			if(isCSRFGuardOk()){
				include "./view/OrderConfirmation.php";
			} else {
				include "./view/Shop.php";
			}
			break;
		case "confirmCheckOut":
			if(isCSRFGuardOk()){
				include "./view/Receipt.php.php";
			} else {
				include "./view/OrderConfirmation.php";
			}
			break;
		case "removeFromCart":
			$inputOk = true;
			$inputOk = $inputOk && isset($_POST['product_id']);
			$inputOk = $inputOk && isCSRFGuardOk();
			if($inputOk){
				if(isset($_SESSION['cart'])){
					if(isset($_SESSION['cart'][$_POST['product_id']])){
						unset($_SESSION['cart'][$_POST['product_id']]);
					}
				}
				include "./view/Shop.php";
			} else {
				include "./view/Shop.php";
			}
			break;
	}

?>
