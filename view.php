<?php
require_once "pdo.php";
require_once "util.php";
session_start();
checkLogin();
?>

<html>
<head>
    <title>Xinchun Li's Resume Registry</title>
    <script src="js/jquery.js"></script>
    <script src="js/jquery_ui.js"></script>
</head>


<body>
<div class="container">
    <h1>Profile Information</h1>

    <?php
    flashMessages();

    $profile_id = $_GET['profile_id'];
    $stmt = $pdo->query("SELECT first_name, last_name, email, headline, summary FROM Profile WHERE profile_id=".$profile_id);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo ('<p>First Name:'.htmlentities($row['first_name']).'</p>');
        echo ('<p>Last Name:'.htmlentities($row['last_name']).'</p>');
        echo ('<p>Email:'.htmlentities($row['email']).'</p>');
        echo ('<p>headline:'.htmlentities($row['headline']).'</p>');
        echo ('<p>Summary:'.htmlentities($row['summary']).'</p>');}

    echo "<p>Positions:<p>";
    echo "<ul>";

    $stmt = $pdo->query("SELECT rank, year, description FROM Position WHERE profile_id=".$profile_id);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>";
        echo $row['rank']," ",$row['year'],"/",$row['description'];
        echo("</li>");}
    ?>
    </ul>
    <p>
        <a href="index.php">Done</a>
    </p>
</div>
</body>
</html>