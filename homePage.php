<html>
<body>
<Title>Login Page</Title>
<?php
$value = getenv('REQUEST_METHOD');
if ($value !=  NULL){
	$uname = $_POST["username"];

	$pword = $_POST["pword"];

	$link = mysqli_connect("localhost", "root", "MS-06ZakuII","users2");
	if(!$link){
        	die("Failed to connect: " . mysqli_connect_error());
	}	
	if ($uname != NULL and $pword != NULL){
		$query = "SELECT username, password FROM users2 WHERE(username='$uname' and password='$pword')";
		if ( !$q_result = $link->query($query) ) {
			echo "Query failed: ". $query->error. "\n";
		}
		else if($q_result->num_rows == 1){
			$url = "http://128.163.141.217/main.php";		
			header("Location: $url");
		}		
		else{
			echo"<b>INVALID USERNAME OR PASSWORD</b><br>";
		}
	}
}




?>
<b>Please enter your login information!</b>

<form action="homePage.php" method="post">
Username: <input type="text" name="username">
Password: <input type="password" name ="pword">
<input type="submit" value="Login">
</form>

<b>Register below!</b>

<form action="signup.php" method="get">
<input type="submit" value="Register">
</form>

</body>
</html>

