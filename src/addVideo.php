<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "elliotan-db", "j2UFkUoAjkXBvZzs", "elliotan-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
} 

$title = $_POST['title'];
$category = $_POST['category'];
if ($_POST['length'] == "") { 
	$length = NULL;
} else {
	$length = $_POST['length'] + 0; 
}
/// Check inputs
if ($_POST['title'] == "") {
	echo 'Please enter a title.<br>';
	echo '<a href="videoStore.php"> Return </a>';
	exit;
}
if ($length != NULL) {
	if (!is_int($length) || $length < 1) {  // 
		echo 'Please enter a valid length.<br>';
		echo '<a href="videoStore.php"> Return </a>';
		exit;
	}
}
/// End checking
		if (!($stmt = $mysqli->prepare("INSERT INTO videoStoreDB (name, category, length) VALUES (?,?,?);"))) {
		    echo "Error during prepare: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("ssi", $title, $category, $length)) {
		   echo "Error during binding: " . $stmt->errno . " " . $stmt->error;
		    exit;
		}
		if (!$stmt->execute()) {
	
		    if ($mysqli->errno == 1062) {
		    	echo "Please enter a new movie.<br>";
		    	echo '<a href="videoStore.php"> Return </a>';
		    }
		    exit;
		}
$stmt->close();
header('Location: videoStore.php');
?>