<html>
<body>

<h1> Register </h1>
<?php
	$name = $password = "";
	$nameErr = $passErr = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		echo "<h2> name: " . $_POST["name"] . " : password " . $_POST["password"] . "</h1>";

		if (strlen($_POST["name"]) <= 3)  {
			$nameErr = "Need more than 3 characters";
		}
		else {
			$name = $_POST["name"];
		}
		if (strlen($_POST["password"]) <= 3)  {
			$passErr = "Need more than 3 characters";
		}
		else {
			$password = $_POST["password"];
		}
	}
?>

<?php
	$con = mysqli_connect("localhost", "tom", "Mcr2534hCmrYr5VR", "my_db");
	if (mysqli_connect_errno($con)) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	/*
	$sql="CREATE TABLE users
	(
		id INT NOT NULL AUTO_INCREMENT,
		username VARCHAR(30) NOT NULL UNIQUE,
		email VARCHAR(30) NOT NULL UNIQUE,
		password VARCHAR(30) NOT NULL,
		PRIMARY KEY(id)
		)";*/
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$sql = "SELECT * FROM users WHERE username='$name' AND password='$password'";
	echo $sql . '<br/>';
	$login = false;
	$result = mysqli_query($con, $sql);
	if ($sql = mysqli_query($con, $sql)) {
		if(count(mysqli_fetch_array($sql)) >= 1) {
			$login = true;
		}
	}
	else {
		echo "Error with database: " . mysqli_error($con);
	}

	if ($login) {
		echo "logged in";
	}
	else {
		echo "Invalid username or password";
	}
	}
	mysqli_close($con);
?>



<form method="post" action="register.php">
	Email: <input type="email" name="email" value="<?php echo $name ?>">
	<?php echo $nameErr; ?><br/>
	Password: <input type="password" name="password">
	<?php echo $passErr; ?><br/>
	<input type="submit">
</form>


<!---->
<!---->
<!---->
<!---->


<h1> Get list of Favourited Songs </h1>

<form method="get" action="favourite.php">
	User ID: <input type="text" name="id" value="<?php echo $name ?>"><br/>
	<input type="submit">
</form>


<h1> Favourite a Song </h1>

<form method="post" action="favourite.php">
	User ID: <input type="text" name="id" value="<?php echo $name ?>"><br/>
	Song Name: <input type="text" name="song"><br/>
	<input type="submit">
</form>


<h1> Remove a Favourited Song </h1>

<form method="post" action="removefav.php">
	User ID: <input type="text" name="id" value="<?php echo $name ?>"><br/>
	Song Name: <input type="text" name="song"><br/>
	<input type="submit">
</form>

</body>
</html>