<?php
class User {
	public  $m_username;
	public $m_home_address;
	public $m_password_hashed;
	public $m_password_salt;
	public function __construct($username, $home_address, $password_hashed, $password_salt) {
		$this->m_username = $username;
		$this->m_home_address = $home_address;
		$this->m_password_hashed = $password_hashed;
		$this->m_password_salt = $password_salt;
	}
	public function isPasswordCorrect($testpassword) {
		//echo sha1($testpassword + $this->m_password_salt) . " "  .  $this->m_password_hashed ;
		
		return (sha1($testpassword . $this->m_password_salt) == $this->m_password_hashed);
	}
}
?>
