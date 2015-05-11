<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "elliotan-db", "j2UFkUoAjkXBvZzs", "elliotan-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

		if (!($stmt = $mysqli->prepare("TRUNCATE TABLE videoStoreDB"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
$stmt->close();
header('Location: videoStore.php');
?>
