<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "elliotan-db", "j2UFkUoAjkXBvZzs", "elliotan-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}
?>

<!DOCTYPE html>

<!-- Text input -->
<form action="addVideo.php" method="POST">
	<title>Assignment 4 part 2</title>
	<h1>Movie Database</h1>
	Title (required): <input type="text" name="title"><br>
	Category: <input type ="text" name="category"><br>
	Length (in minutes): <input type ="text" name="length"><br>
	<br>
	<input type="submit" value = "Add to Database"><br>
</form>
<br>

<!-- Movie Table from ONID DB -->
	<table border='1'>
	<tr>
	<th>Name
	<th>Category
	<th>Length
	<th>Rented
	<th>Check In/Check Out
	<th>Delete
<?php
if ($_POST == NULL || (isset($_POST['selectCategory']) && $_POST['selectCategory'] == "All Movies")) {

		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoStoreDB ORDER BY name"))) {
		    echo "Error during prepare: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Error during execute: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
} else { 
		$category = $_POST['selectCategory'];
		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM videoStoreDB WHERE category = ? ORDER BY name"))) {
		    echo "Error during prepare: " . $mysqli->errno . " " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("s", $category)) {
		    echo "Error during binding: " . $stmt->errno . " " . $stmt->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Error during execute: " . $mysqli->errno . " " . $mysqli->error;
		    exit; 
		}
}
		$out_id = NULL;
		$out_name = NULL;
		$out_category = NULL;
		$out_length = NULL;
		$out_rented = NULL;
		if (!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
		    echo "Error during binding: " . $stmt->errno . " " . $stmt->error;
		    exit;
		}
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$out_name" . '</td>
		    	  	<td>' . "$out_category" . '</td>
		    	 	<td>' . "$out_length" . '</td>
		    	 	<form action="videoRent.php" method="POST">';
		    	 	if ($out_rented == 0) {
		    	 		echo '<td>Checked In</td>
		    	 			<td>
		    	 			<input type="hidden" name="videoID" value="' . "$out_id" . '">
					  		<input type="submit" name="status" value="Check Out">
					  		</td>';
		    	  	} else {
						echo '<td>Checked Out</td>
							<td>
							<input type="hidden" name="videoID" value="' . "$out_id" . '">
					  		<input type="submit" name="status" value="Check In">
							</td>';
					}
					echo '
					</form>
					<form action="deleteVideo.php" method="POST">
					<td>
					
					 <input type="hidden" name="videoID" value="' . "$out_id" . '">
					 <input type="submit" value="Delete">					 
					 </td>
					 </form>
				</tr>';
		}
?>
	</table>
	<br>


<!--Category Filter Dropdown-->
	<form action="videoStore.php" method="POST">
	Category Filter: 
	<select name="selectCategory"> 
	<option value="All Movies">All Movies</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT category FROM videoStoreDB WHERE category != ''"))) {
    		echo "Error during prepare: " . $mysqli->errno . " " . $mysqli->error;
    		exit;
		}
		if (!$stmt->execute()) {
    		echo "Error during execute: " . $mysqli->errno . " " . $mysqli->error;
    		exit;
		}
		$out_category = NULL;
		if (!$stmt->bind_result($out_category)) {
    		echo "Error during binding: " . $stmt->errno . " " . $stmt->error;
    		exit;
		}
		
		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_category" . '">' . "$out_category" . '</option>';
		}
?>
	</select>
	<input type="submit" value = "Filter"/><br>
	</form>
	<br>


<!-- Delete button -->
	<form action="clearAll.php" method="POST">
	Clear All: 
	<input type="submit" value = "Clear"/><br>
	</form>
	</center>
</body>
</html>

<?php
$stmt->close();
?>