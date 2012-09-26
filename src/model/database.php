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
			break;
		case PRODUCT:
			break;
		case SESSION:
			break;
		} 
	}
}
?>