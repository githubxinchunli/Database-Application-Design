<?php
require_once "pdo.php";
require_once "Utility.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xinchun Li's Resume Registry</title>
  <?php require_once "head.php";?>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>
<body>
<div class="container">
	<h1>Xinchun Li's Resume Registry</h1>
    <?php
    flashMessages();

    if (isset($_SESSION['user_id'])) {
        echo('<table border="1">' . "\n");
        echo("<tr><td>Name</td><td>Headline</td><td>Action</td></tr>");
        $stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM Profile WHERE user_id = " . $_SESSION['user_id']);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo("<tr><td>");
            echo('<a href="view.php?profile_id=' . $row['profile_id'] . '">'.htmlentities($row['first_name'].' '.$row['last_name']).'</a>');
            echo("</td><td>");
            echo(htmlentities($row['headline']));
            echo("</td><td>");
            echo('<a href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> / ');
            echo('<a href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>');
            echo("</td></tr>\n");
        }
        echo("</table>");
        echo("<a href='logout.php'>Logout</a>\n");
        echo("<a href='add.php'>Add New Entry</a>");
    }else{
        echo('<p><a href="login.php">Please log in</a></p>');
    }
    ?>
</div>
</body>
</html>