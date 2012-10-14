<?php
include_once "./model/user.php";
include_once "./model/product.php";
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "siemens");
define("DB_DATABASE", "webshop");

define("USER", "User");
define("PRODUCT", "Product");
class Database {
	private $mysql_conn;
	public function __construct() {
		$this->connect();
	}
	
	private function connect() {
		$this->mysql_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD , DB_DATABASE);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
	
	public function create($object, $type) {
// 		echo "create : " . $type;
		switch ($type) {
		case USER:
			if ($stmt = $this->mysql_conn->prepare("INSERT INTO ". USER . " ( username, home_address, password_hashed, password_salt ) VALUES ( ?, ?, ?, ?)")) {
				$stmt->bind_param('ssss', $object->m_username, $object->m_home_address, $object->m_password_hashed, $object->m_password_salt);
				$stmt->execute();
				print_r($stmt);
				if( $stmt->affected_rows > 0 ) {
					return true;
				} else {
// 					echo $this->mysql_conn->error;
				}
				$stmt->close();
			} else {
// 				echo $this->mysql_conn->error;
			}
			break;
		case PRODUCT:
			if ($stmt = $this->$mysql_conn->prepare("INSERT INTO ". PRODUCT . " ( product_id, name, price ) VALUES ( ?, ?, ?)")) {
				$stmt->bind_param('ssd', $object->m_product_id, $object->m_home_address, $object->m_password_hashed, $object->m_password_salt);
				$stmt->execute();
				print_r($stmt);
				if( $stmt->affected_rows > 0 ) {
					return true;
				}
				$stmt->close();
			}
			break;
		} 
		return false;
	}
	public function read($id, $type) {
		switch ($type) {
		case USER:
			if ($stmt = $this->mysql_conn->prepare("SELECT username,home_address,password_hashed,password_salt FROM " . USER . " WHERE username=?")) {
				$stmt->bind_param('s', $id);
				$username = "";
				$home_address = "";
				$password_hashed = "";
				$password_salt = "";
				$stmt->execute();
				$stmt->bind_result($username,$home_address,$password_hashed,$password_salt);
				$stmt->fetch();
				$stmt->close();
				$user = new User($username,$home_address,$password_hashed,$password_salt);
// 				print_r( $user);
				return $user;
			}
			break;
		case PRODUCT:
			if ($stmt = $this->mysql_conn->prepare("SELECT product_id, name, price FROM " . PRODUCT . " WHERE product_id=?")) {
				$stmt->bind_param('s', $id);
				$product_id = "";
				$name = "";
				$price = "";
				$stmt->execute();
				$stmt->bind_result($product_id,$name,$price);
				$stmt->fetch();
				$stmt->close();
				$product = new Product($product_id,$name,$price);
				return $product;
			}
			break;
		} 
	}
	public function getAllProducts(){
		if ($stmt = $this->mysql_conn->prepare("SELECT product_id, name , price FROM " . PRODUCT)) {
			$arr = array();
			$product_id = "";
			$name = "";
			$price = "";
			$stmt->execute();
			$stmt->bind_result($product_id,$name,$price);
			while($stmt->fetch()) {
				array_push($arr,new Product($product_id,$name,$price));
			}
			$stmt->close();
			return $arr;
		}
	}
}
?>