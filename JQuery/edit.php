<?php
require_once "pdo.php";
require_once "util.php";
session_start();

if ( isset($_SESSION['edit_error']) ) {
    echo '<p style="color:red">'.$_SESSION['edit_error']."</p>\n";
    unset($_SESSION['edit_error']);
}

if ( isset($_POST['submit'])) {
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['edit_error'] = "All fields are required";
        header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
        return;
    }
    elseif ( strpos($_POST['email'], '@') === false) {
        $_SESSION['edit_error'] = "Email address must contain @";
        header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
        return;
    }
    else {
        $sql = "UPDATE Profile SET first_name = :fst, last_name = :lst, email = :em, headline = :hl, summary = :sum 
                WHERE profile_id = :profile_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':fst' => $_POST['first_name'],
            ':lst' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':hl' => $_POST['headline'],
            ':sum' => $_POST['summary'],
            ':profile_id' => $_POST['profile_id']));
     
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
               ':desc' => $desc));
            $rank++;
        }
        $_SESSION['success'] = 'Profile Saved';
        header("Location: index.php");
        return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

$first = htmlentities($row['first_name']);
$last = htmlentities($row['last_name']);
$email = htmlentities(($row['email']));
$headline = htmlentities($row['headline']);
$summary = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xinchun Li's Resume Registry - Edit Profile</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>

<body>
    <h1>Editing Profile for UMSI</h1>
    <form method="post">
        <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
        <p>First Name:
            <input type="text" name="first_name" value="<?= $first ?>"></p>
        <p>Last Name:
            <input type="text" name="last_name" value="<?= $last ?>"></p>
        <p>Email:
            <input type="text" name="email" value="<?= $email ?>"></p>
        <p>Headline:
            <input type="text" name="headline" value="<?= $headline ?>"></p>
        <p>Summary:</p>
        <textarea name="summary" rows="7" cols="40"><?= $summary ?></textarea>
        <p>
            <input type="submit" name="submit" value="Save"/>
            <input type="button" name="submit" value="Cancel" onclick="location.href='index.php'"></p>
    </form>
<script>
countPos = 0;

$(document).ready(function() {
    windows.console && console.log('Document ready called');
    $('addPos').click(function(event)){
        event.preventDefault();
        if (countPos >= 9) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
    countPos ++;
    windows.console && console.log("Adding position " + countPos);
    $('#position_fields').append(
        '<div id= "position" + countPos+ '"> \
        <p>Year: <input type = "text" name= "year" + countPos + '" value = "" / > \
        <input type = "button" value = "-"  \
            onclick = "$(\'#position' + countPos + '\').remove();return false;"></p> \
        <textarea name = "desc' + countPos+ '" rows = "8" cols= "80"></textarea>\
        </div>');
    });    
});

</script>
</body>
</html>