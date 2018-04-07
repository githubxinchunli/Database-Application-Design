<?php
require_once "pdo.php";

session_start();

if(isset($_POST['add'])){
    if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 || strlen($_POST['email'])<1 ||
    strlen($_POST['headline'])<1 || strlen($_POST['summary'])<1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    elseif (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = 'Email address must contain @';
        header("Location: add.php");
        return;
    }
    else {
        $sql = "INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)
              VALUES (:uid, :fst, :lst, :em, :hl, :sum)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fst' => $_POST['first_name'],
            ':lst' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':hl' => $_POST['headline'],
            ':sum' => $_POST['summary']));
        $_SESSION['success'] = 'Profile Added';
        header("Location: index.php");
        return;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xinchun Li's Resume Registry - Add New</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>
<body>
<div class="container">
    <h1>Adding Profile for UMSI</h1>
    <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <form method="post">
        <p>First Name:
            <input type="text" name="first_name"/></p>
        <p>Last Name:
            <input type="text" name="last_name"/></p>
        <p>Email:
            <input type="text" name="email"/></p>
        <p>Headline:
            <input type="text" name="headline"/></p>
        <p>Summary:
            <textarea name="summary" rows="7" cols="40"></textarea>
        <p><input type="submit" name="add" value="Add"></p>
        <p><input type="button" value="Cancel" onclick="location.href='index.php'"></p>
    </form>
</div>
</body>
</html>