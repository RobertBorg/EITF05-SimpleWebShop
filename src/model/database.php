<?php
define("DB_USER", "db_username");
define("DB_PASSWORD", "db_password");
define("DB_DATABASE", "db_database");

define("USER", "User");
define("PRODUCT", "Product");
define("SESSION", "Session");
class Database {
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