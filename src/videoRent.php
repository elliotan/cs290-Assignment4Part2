<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "elliotan-db", "j2UFkUoAjkXBvZzs", "elliotan-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

$videoID = $_POST['videoID'];
if ($_POST['status'] == "Check Out") {
		if (!($stmt = $mysqli->prepare("UPDATE videoStoreDB SET rented = 1 WHERE id = ?"))) {
		    echo "Error during prepare: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("i", $videoID)) {
		    echo "Error during binding: " . $stmt->errno . " " . $stmt->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Error during execute: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}

}
if ($_POST['status'] == "Check In") {
		if (!($stmt = $mysqli->prepare("UPDATE videoStoreDB SET rented = 0 WHERE id = ?"))) {
		    echo "Error during prepare: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("i", $videoID)) {
		    echo "Error during binding: " . $stmt->errno . " " . $stmt->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Error during execute: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
	
}
$stmt->close();
header('Location: videoStore.php');
?>
