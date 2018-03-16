<?php
require_once "pdo.php";
session_start();
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: logout.php");
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Xinchun Li - Automobiles Database</title>
<?php require_once "pdo.php"; ?>
</head>

<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>

<?php
if ( !isset($_SESSION['name']) ){
    echo ('<p><a href="login.php">Please log in</a></p>'."\n");
    echo ('<p>Attempt to <a href="add.php">add data</a> without logging in</p>');
}
?>
</div>
<div>
<?php
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
};

if (isset($_SESSION['name'])){
  echo('<table border="1">'."\n");
  $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
  if ( $stmt->rowCount() > 0){
    echo ("<tr><th>");
    echo ("Make</th>");
    echo ("<th>Model</th>");
    echo ("<th>Year</th>");
    echo("<th>Mileage</th>");
    echo("<th>Action</th>");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo(htmlentities($row['make']));
        echo("</td><td>");
        echo(htmlentities($row['model']));
        echo("</td><td>");
        echo(htmlentities($row['year']));
        echo("</td><td>");
        echo(htmlentities($row['mileage']));
        echo("</td><td>");
        echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
        echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
        echo("</td></tr>\n");
      };
  } else {
    echo('No rows found.');
  };
  echo('</table>');
  echo("<a href='add.php'>Add New Entry</a>"."<br/>");
  echo("<a href='logout.php'>Logout</a>");
}
?>

</div>
</body>
</html>
