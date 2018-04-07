<?php

session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

if (isset($_POST['add'])) {
    if (strlen($_POST['first_name']) === 0||strlen($_POST['last_name']) === 0||
        strlen($_POST['email']) === 0||strlen($_POST['headline']) === 0)||strlen($_POST['summary']) === 0){
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }
    elseif (strpos($_POST['email'],'@') == false){
        error_log("Login fail ".$_POST['email'].$_POST['pass']);
        $_SESSION['error'] = 'Email must have an at-sign (@)';
        header("Location: login.php");
        return;
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO Profile
        (first_name, last_name, email, headline, summary) VALUES ( :first_name, :last_name, :email, :headline, :summary)');
        $stmt->execute(array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':headline' => $_POST['headline']
                ':summary' => $_POST['summary'])
        );
        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
    }
}
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xinchun Li JavaScript</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>
<body>
<div class="container">
<h1>Tracking Profile for <?= htmlentities($_SESSION['name'])?></h1>
    <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <form method="post">
        <p>First Name:
            <input type="text" name="first_name" size="60"/></p>
        <p>Last Name:
            <input type="text" name="last_name" size="60"/></p>
        <p>Email:
            <input type="text" name="email" size="30"/></p>
        <p>Headline:
            <input type="text" name="headline" size="30"/></p>
        <p>Summary:
            <input type="text" name="summary" size="30"/></p>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>