<?php
require_once "pdo.php";
session_start();

if ( isset($_SESSION['edit_error']) ) {
    echo '<p style="color:red">'.$_SESSION['edit_error']."</p>\n";
    unset($_SESSION['edit_error']);
}

if ( isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id'])) {
    if (strlen($_POST['make']) === 0 || strlen($_POST['model']) === 0) {
        $_SESSION['edit_error'] = "All fields are required";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }
    elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
        $_SESSION['edit_error'] = "Mileage and year must be numeric";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }
    else {
        $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year, mileage = :mileage 
            WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_POST['autos_id']));
        $_SESSION['success'] = 'Record edited';
        header('Location: index.php');
        return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$m = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<p>Editing Automobile</p>
<form method="post">
    <p>Make:
        <input type="text" name="make" value="<?= $m ?>"></p>
    <p>Model:
        <input type="text" name="model" value="<?= $mo ?>"></p>
    <p>Year:
        <input type="text" name="year" value="<?= $y ?>"></p>
    <p>Mileage:
        <input type="text" name="mileage" value="<?= $mi ?>"></p>
    <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
    <p><input type="submit" value="Save"/>
        <a href="index.php">Cancel</a></p>
</form>