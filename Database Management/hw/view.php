<?php
    if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

    // Check if we are logged in!
    if ( ! isset($_SESSION["account"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else { ?>
       <p>This is where a cool application would be.</p>
       <p>Please <a href="logout.php">Log Out</a> when you are done.</p>
    <?php } ?>
</body></html>    if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

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