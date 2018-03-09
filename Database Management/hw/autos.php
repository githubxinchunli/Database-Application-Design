<?php

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}


require_once "pdo.php";

$failure = false; 
$success = false;

if (!empty($_POST)){
	if(strlen($_POST['make']) < 1){
		$failure = "Make is required";
		
	} else {
		if(isset($_POST['year']) && isset($_POST['mileage'])){
			if(is_numeric($_POST['year'])&&is_numeric($_POST['mileage'])){
			$success=true;
			$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
		    $stmt->execute(array(
	        ':mk' => htmlentities($_POST['make']),
	        ':yr' => $_POST['year'],
	        ':mi' => $_POST['mileage']));
	        
			} else{
				$failure = "Mileage and year must be numeric";
			}
		} else {
			$failure = "Mileage and year must be numeric";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title> Xinchun Li bd853b47</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for
<?php
if ( isset($_REQUEST['name']) ) {
    echo htmlentities($_REQUEST['name']);
    echo "</p>\n";
}
?>
</h1>
<?php
if ( $failure !== false ) {
    echo('<p style="color: red;font-size:12px;">'.htmlentities($failure)."</p>\n");
}
if ( $success !== false ) {
    echo('<p style="color: green;font-size:12px;">'.htmlentities("Record inserted")."</p>\n");
}
?>

<form method="post">
<p>Make:<input type="text" name="make" size="40"></p>
<p>Year:<input type="text" name="year"></p>
<p>Mileage:<input type="text" name="mileage"></p>
<p><input type="submit" value="Add New"/></p>
<p><input type="submit" name="logout" value="Logout"></p>
</form>

<h2>Automobiles</h2>
<ul>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	echo("<li>");
	echo($row['year'].' '. $row['make']." / ".$row['mileage']);
	echo("</li>\n");
}
?>
</ul>
</div>
</body>
</html>





</div>
</body>

