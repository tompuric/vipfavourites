<?php
	$method = $_SERVER["REQUEST_METHOD"];
	$con = mysqli_connect("localhost", "tom", "Mcr2534hCmrYr5VR", "my_db");
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	$id = $song = "";

	// DELETE a song from a users favourites

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
			deleteSong($con, $id, $song);
		}
	}

	function deleteSong($con, $id, $song) {
		$sql = "DELETE FROM favourites WHERE user_id = '$id' AND song = '$song'";
		if (mysqli_query($con, $sql)) {
			if (mysqli_affected_rows($con) > 0)
				echo "Successfully Removed Favourited Item";
			else
				echo "Unable to unfavourite the item";
		}
		else {
			echo "Unable to unfavourite the item";
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

	function clean($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

?>