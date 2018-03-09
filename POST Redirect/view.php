<?php
    session_start();
    
    if ( ! isset($_SESSION['name']) ) {
	    die('Not logged in');
	}

	// for accessing sql
	require_once "pdo.php";
?>
<html>
<head>
<title>Xinchun Li bd853b47</title>
	<?php require_once "bootstrap.php"; ?>
</head>
<!-- <body style="font-family: sans-serif;"> -->
<body>
<h1>Tracking Autos for
<?php
if ( isset($_SESSION['name']) ) {
    echo htmlentities($_SESSION['name'])."</p>\n";
}
?>
</h1>

<?php 

    if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
	}
 
?>
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
<p>
	<a href="add.php">Add New</a> |
	<a href="logout.php">Logout</a>
</p>

</body>
</html>
