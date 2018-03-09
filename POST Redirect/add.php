<?php

	session_start();

	if ( ! isset($_SESSION['name']) ) {
	    die('Not logged in');
	}

	// for accessing sql
	require_once "pdo.php";

if (!empty($_POST)){

	// if cancel bottom clicked
	if(isset($_POST['cancel'])) { 
		header("Location: view.php");
		return;
	 }
	if(strlen($_POST['make']) < 1){
		$_SESSION['error'] = "Make is required";
		
	} else {
		if(isset($_POST['year']) && isset($_POST['mileage'])){
			if(is_numeric($_POST['year'])&&is_numeric($_POST['mileage'])){
			$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
		    $stmt->execute(array(
	        ':mk' => htmlentities($_POST['make']),
	        ':yr' => $_POST['year'],
	        ':mi' => $_POST['mileage']));

	        $_SESSION['success'] = "Record inserted";
	        //redirect
			header("Location: view.php");
			return;

			} else{
				$_SESSION['error'] ="Mileage and year must be numeric";
			}
		} else {
			$_SESSION['error'] = "Mileage and year must be numeric";
		}
	}

	header("Location: add.php");
    return;

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Xinchun Li bd853b47</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for
<?php
if ( isset($_SESSION['name']) ) {
    echo htmlentities($_SESSION['name'])."</p>\n";
}
?>
</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>

<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>
</body>
</html>





</div>
</body>

