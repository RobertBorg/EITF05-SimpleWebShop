<?php
class User {
	private $m_username;
	private $m_home_address;
	private $m_password_hashed;
	private $m_password_salt;
	public function __construct($username, $home_address, $password_hashed, $password_salt) {
		$this->m_username = $username;
		$this->m_home_address = $home_address;
		$this->m_password_hashed = $password_hashed;
		$this->m_password_salt = $password_salt;
	}
	public function isPasswordCorrect($testpassword) {
		return sha1($testpassword + $this->m_password_salt) == $this->m_password_hashed;
	}
}
?>
