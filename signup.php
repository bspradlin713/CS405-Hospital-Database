<!DOCTYPE html>
<html>
<?php
$method = getenv("REQUEST_METHOD");
if($method == "POST"){
	$username = $_POST["uname"];
	$password = $_POST["p1"];
	$passwordConfirm = $_POST["p2"];

	$link = mysqli_connect("localhost","root", "MS-06ZakuII","users2");
	if(!$link){
        	die("Failed to connect: " . mysqli_connect_error());
	}	
	else{
        	$sqlUserNames = "SELECT username FROM users2 WHERE username = '$username'";
		$q_results = $link->query($sqlUserNames);
		if (!$q_results) {
			echo "Query failed: ". $link->error. "\n";
			exit;
			
		}
		else if ($q_results->num_rows == 1){
			echo "<b>USERNAME EXISTS</b><br>";
			
		}  
		else if ($password === $passwordConfirm && strlen($password) >= 6){
			$insertQuery = "INSERT INTO users2(username, password) VALUES ('$username', '$password')";
			if($link->query($insertQuery)){
				echo"ADDED\n";
				header("Location: http://128.163.141.217/main.php");
			}
		}
		else{
			echo "<b>Invalid Password! Please retry!</b><br>";
		}
	}
}
?> 

<body>
<title>Register:</title>

<b>Register Below:</b><br>

<form action="signup.php" method="post">
Username <input type="text" name ="uname"><br>
Password <input type="password" name ="p1"><br>
Re-Type Password <input type="password" name="p2"><br>
<input type="submit">
</form>
</body>
</html>

