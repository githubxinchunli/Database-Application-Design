<?php
require_once "pdo.php";
require_once "util.php";

session_start();

if (! isset($_SESSION['user_id'])) {
    die("ACCESS DENIED");
    return;
}

if ( isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {

    $msg = validateProfile();
    if ( is_string($msg)) {
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return;
    }

    $msg = validatePos();
    if ( is_string($msg)) {
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return;
    }


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
    $profile_id = $pdo -> lastInsertId();


    $rank = 1;
    for ($i = 1; $i <= 9; $i ++) {
        if ( ! isset($_POST['year'.$i])) continue;
        if ( ! isset($_POST['desc'.$i])) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['year'.$i];
        
        $sql = "INSERT INTO Position (profile_id, rank, year, description)
            VALUES ( :pid, :rank, :year, :desc)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':pid' => $profile_id,
        ':rank' => $rank,
        ':year' => $year,
        ':desc' => $desc)
    );
    $rank++;
}

    $_SESSION['success'] = 'Profile Added ';
    header("Location: index.php");
    return;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xinchun Li's Resume Registry - Add New</title>
  <?php require_once "head.php"; ?>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>
<body>
<div class="container">
    <h1>Adding Profile for UMSI</h1>
    <?php
    flashMessages();
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
        <p>
        Position; <input type="submit" id="addPos" value= "+">
        <div id = "position_fields">
        </div>
        </p>
        <p><input type="submit" name="add" value="Add"></p>
        <p><input type="button" value="Cancel" onclick="location.href='index.php'"></p>
    </form>
<script>
countPos = 0;

$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
            onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });
});

</script>
</div>
</body>
</html>