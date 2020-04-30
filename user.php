<?php
	include "Crud.php";
	include "authenticator.php";
	include_once "DBConnector.php";
	class User implements Crud,Authenticator{
		private $user_id;
		private $first_name;
		private $last_name;
		private $city_name;

		private $username;
		private $password;

		function __construct($first_name,$last_name,$city_name,$username,$password){
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->city_name = $city_name;
			$this->username = $username;
			$this->password = $password;
		}

		public static function create() {
			$instance = new self();
			return $instance;
		}
		//username setter
		public function setUsername($username){
			$this->username = $username;
		}

		//username getter
		public function getUsername(){
			return $this->username;
		}
		//password setter
		public function setPassword($password){
			$this->password = $password;
		}
		//password getter
		public function getPassword(){
			return $this->password;
		}
		//user_id setter
		public function setUserId($user_id){
			$this->user_id = $user_id;
		}
		//user_id getter
		public function getUserId(){
			return $this->$user_id;
		}
//TO IMPLEMENT THEM
		public function save(){
			$fn = $this->first_name;
			$ln = $this->last_name;
			$city = $this->city_name;
			$uname = $this->username;
			$this->hashPassword();
			$pass = $this->password;

			//$res = mysql_query("INSERT INTO user(first_name,last_name,user_city)VALUES('$fn','$ln','$city')") or die("Error " . mysql_error());
			$db=connect();
			$res = $db->query("INSERT INTO `user`(`first_name`,`last_name`,`user_city`,`username`,`password`)VALUES('$fn','$ln','$city','$uname','$pass');");
			return $res;

		}
		public function readAll(){
			return null;
		}
		public function readUnique(){
			return null;
		}
		public function search(){
			return null;
		}
		public function update(){
			return null;
		}
		public function removeOne(){
			return null;
		}
		public function removeAll(){
			return null;
		}
		public function validateForm(){
			//RETURN TRUE IF VALUES ARE NOT EMPTY
			$fn = $this->first_name;
			$ln = $this->last_name;
			$city = $this->city_name;
			if($fn == "" || $ln == "" || $city == "") {
				return false;
			}
			return true;
		}
		public function createFormErrorSessions(){
			session_start();
			$_SESSION['form_errors'] = "All fields are required";
		}
		public function hashPassword(){
			//function hashes the password
			$this->password = password_hash($this->password,PASSWORD_DEFAULT);
		}
		public function isPasswordCorrect(){
			$db=connect();
			$found = false;
			$res = mysql_query("SELECT * FROM user" )or die("Error" . mysql_error());

			while($row=mysql_fetch_array($res)){
				if(password_verify($this->getPassword(),$row['password']) && $this->getUsername()== $row['username']){
					$found = true;
				}
			}
			//close database
			$db->closeDatabase();
			return $found;
			//return true;

		}
		public function login(){
			if($this->isPasswordCorrect()){
				//password is correct
				header("Location:private_page.php");
			}
		}
		public function createuserSession(){
			session_start();
			$_SESSION['username'] = $this->getusername();
		}
		public function logout(){
			session_start();
			unset($_SESSION['username']);
			session_destroy();
			header("Location:lab1.php");
		}

	}
?>

