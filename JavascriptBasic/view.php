<?php
session_start();
require_once "pdo.php";

# Check if logged in
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xinchun Li </title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>
<body>
<h1>Tracking UMSI profile for <?= htmlentities($_SESSION['name'])?></h1>
    
    <?php
        if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
    ?>

    <h2>UMSI profile</h2>
    <ul>
        <?php
        $stmt = $pdo->query("SELECT first_name, last_name, email, headline, summary FROM Profile");
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo ("<li>");
            echo(htmlentities($row['first_name'])."\n");
            echo(htmlentities($row['last_name']));
            echo(' / ');
            echo(htmlentities($row['email']));
            echo(htmlentities($row['headline']));
            echo(htmlentities($row['summary']));
            echo('</li>');
        }
        ?>
    </ul>
    <a href="add.php">Add New</a> | <a href="logout.php">Logout</a>
</body>
</html>