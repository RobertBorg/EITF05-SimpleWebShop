<?php
define("DB_HOST", "localhost");
define("DB_USER", "db_username");
define("DB_PASSWORD", "db_password");
define("DB_DATABASE", "SimpleWebShop");

define("USER", "User");
define("PRODUCT", "Product");
define("SESSION", "Session");
class Database {
	private $mysql_conn;
	public function __construct() {
		connect();
	}
	
	private function connect() {
		$this->mysql_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD , DB_DATABASE);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
	
	public function create($object, $type) {
		switch ($type) {
		case USER:
			break;
		case PRODUCT:
			break;
		case SESSION:
			break;
		} 
	}
	public function read($id, $type) {
		switch ($type) {
		case USER:
			if ($stmt = $mysql_conn->prepare("SELECT username,home_address,passsword_hashed,password_salt FROM " . USER . " WHERE username=?")) {
				$username = "";
				$home_address = "";
				$password_hashed = "";
				$password_salt = "";
				$stmt->execute();
				$stmt->bind_reslut($username,$home_address,$password_hashed,$password_salt);
				$stmt->fetch_reslut();
				$stmt->close();
				$user = new User($username,$home_address,$password_hashed,$password_salt);
				return $user;
			}
			break;
		case PRODUCT:
			if ($stmt = $mysql_conn->prepare("SELECT product_id.name,price FROM " . PRODUCT . " WHERE product_id=?")) {
				$product_id = "";
				$name = "";
				$price = "";
				$stmt->execute();
				$stmt->bind_reslut($product_id,$name,$price);
				$stmt->fetch_reslut();
				$stmt->close();
				$product = new Product($product_id,$name,$price);
				return $product;
			}
			break;
		case SESSION:
			break;
		} 
	}
}
?>