<?php 
	$method = $_SERVER["REQUEST_METHOD"];
	$con = mysqli_connect("localhost", "tom", "Mcr2534hCmrYr5VR", "my_db");
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	$id = $song = "";

	// GET list of songs
	if ($method == "GET") {
		$id = clean($_GET["id"]);

		if (empty($id) || !userExists($con, $id)) {
			echo "invalid user id";
		}
		else {
			$list = getSongs($con, $id);
			if (count($list) == 0)
				echo "You currently have no favourited songs. Go favourite some!";
			else {
				echo json_encode(array('songs'=>$list));
			}
		}
	}

	// POST a song to users favourites
	if ($method == "POST") {
		$id = clean($_POST["id"]);
		$song = clean($_POST["song"]);

		if (empty($id) || !userExists($con, $id)) {
			echo "invalid user id";
		}
		elseif (empty($song)) {
			echo "invalid song";
		}
		else {
			addSong($con, $id, $song);
		}
	}

	

	function addSong($con, $user, $song) {
		$sql = "INSERT INTO favourites (user_id, song) VALUES ('$user', '$song')";
		if (favouriteExists($con, $user, $song)) {
				echo "Song already favourited";
		}
		else {
			if ($sql = mysqli_query($con, $sql)) {
				echo "Song added to favourites";
			}
			else {
				echo "Failed to add to favourites";
			}
		}	
	}

	function getSongs($con, $id) {
		$list = array();
		$sql = "SELECT song FROM favourites WHERE user_id = '$id'";
		if ($sql = mysqli_query($con, $sql)) {
			while ($row = mysqli_fetch_array($sql)) {
				array_push($list, $row[0]);
			}
			return $list;
		}
		else {
			return $list;
		}
	}

	function userExists($con, $id) {
		$sql = "SELECT * FROM users WHERE id = '$id'";
		if ($sql = mysqli_query($con, $sql)) {
			if (count(mysqli_fetch_array($sql)) >= 1)
				return true;
			else
				return false;
		}
	}

	function favouriteExists($con, $user, $song) {
		$sql = "SELECT * FROM favourites WHERE user_id = '$user' AND song = '$song'";
		if ($sql = mysqli_query($con, $sql)) {
			if (count(mysqli_fetch_array($sql)) >= 1)
				return true;
			else
				return false;
		}
	}

	function clean($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
