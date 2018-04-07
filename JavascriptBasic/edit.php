<?php
require_once "pdo.php";
session_start();

if ( isset($_SESSION['edit_error']) ) {
    echo '<p style="color:red">'.$_SESSION['edit_error']."</p>\n";
    unset($_SESSION['edit_error']);
}

if ( isset($_POST['first_name']) && isset($_POST['last_name'])
    && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {
    if (strlen($_POST['first_name']) === 0 || strlen($_POST['last_name']) === 0 || strlen($_POST['email']) === 0 || strlen($_POST['headline']) === 0 || strlen($_POST['summary']) === 0) {
        $_SESSION['edit_error'] = "All fields are required";
        header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
        return;
    }
    elseif ((strpos($_POST['email'],'@') == false){
        $_SESSION['edit_error'] = "Email address must have @";
        header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
        return;
    }
    else {
        $sql = "UPDATE Profile SET first_name = :first_name,
            last_name = :last_name, email = :email, headline = :headline, summary = :summary 
            WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':first_name' => $_POST['first_name'],
            ':last_name' => $_POST['last_name'],
            ':email' => $_POST['email'],
            ':headline' => $_POST['headline'],
            ':summary' => $_POST['summary']
            ':user_id' => $_POST['user_id'],
));
        $_SESSION['success'] = 'Record edited';
        header('Location: index.php');
        return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

$first_name = htmlentities($row['first_name']);
$last_name = htmlentities($row['last_name']);
$email = htmlentities($row['email']);
$headline = htmlentities($row['headline']);
$summary = htmlentities($row['summary']);
$users_id = htmlentities($row['users_id']);
?>
<p>Editing Profile</p>
<form method="post">
    <p>First Name:
        <input type="text" name="first_name" value="<?= $first_name ?>"></p>
    <p>Last Name:
        <input type="text" name="last_name" value="<?= $last_name ?>"></p>
    <p>Email:
        <input type="text" name="email" value="<?= $email ?>"></p>
    <p>Headline:
        <input type="text" name="headline" value="<?= $headline ?>"></p>
    <p>Summary:
        <input type="text" name="summary" value="<?= $summary ?>"></p>
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <p><input type="submit" value="Save"/>
        <a href="index.php">Cancel</a></p>
</form>