<?php
	$email = $password = "";
	if ($_SERVER["REQUEST_METHOD"] == 'POST') {
		$email = clean($_POST["email"]);
		$password = clean($_POST["password"]);

		if (empty($email) || !validEmail($email)) {
			echo "invalid email";
		}
		elseif (empty($password)) {
			echo "invalid password";
		}
		else {
			$con = mysqli_connect("localhost", "tom", "Mcr2534hCmrYr5VR", "my_db");
			if (emailExists($con, $email)) {
				echo "Email already exists";
			}
			else {
				if (register($con, $email, $password))
					echo "Register Successful";
				else
					echo "Failed to Register";
			}
			mysqli_close($con);
		}
	}

	function register($con, $email, $password) {
		$sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
		if ($sql = mysqli_query($con, $sql)) {
			return true;
		}
		else {
			echo "Error with database: " . mysqli_error($con);
			return false;
		}
	}

	function emailExists($con, $email) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		if ($sql = mysqli_query($con, $sql)) {
			if(count(mysqli_fetch_array($sql)) >= 1) {
				return true;
			}
			return false;
		}
		else {
			echo "Error with database: " . mysqli_error($con);
			return true;
		}
	}

	function validEmail($email) {
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
	  	return false;
	  }
	  return true;
	}

	function clean($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	

?>