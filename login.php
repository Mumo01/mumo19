<?php
//login code
	include_once 'DBConnector.php';
	$db=connect();

	include_once 'user.php';

	//connect to databse
		if(isset($_POST['btn-login'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$instance = User::create();
		$instance->setPassword($password);
		$instance->setUsername($username);

		if($instance->isPasswordCorrect()){
			$instance->login();
			//close db
			$db->closeDatabase();
			//create user session
			$instance->createUserSession();
		}else{
			$db->closeDatabase();
			header("Location:login.php");
		}

	}
?>
<html>
	<head>
		<title>Title goes here</title>
		<script type="text/javascript" src="validate.js"></script>
		<link rel="stylesheet" type="text/css" href="validate.css">
	</head>
	<body>

		<form method="post" name="login" id="login" action="<?=$_SERVER['PHP_SELF']?>">
			<table align="center">
				<tr>
					<td><input type="text" name="username" placeholder = "Username" /></td>
				</tr>
				<tr>
					<td><input type="password" name="password" placeholder = "Password" /></td>
				</tr>

				<tr>
					<td><a href="login.php">LOGIN</a></td>
				</tr>
			</table>
		</form>
	</body>
</html>
