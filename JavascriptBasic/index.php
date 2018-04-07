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
<title>Xinchun Li - JavaScript</title>
<?php require_once "pdo.php"; ?>
</head>

<body>
<div class="container">
<h1>Xinchun Li's Resume Registry</h1>

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
  $stmt = $pdo->query("SELECT first_name, last_name, email, headline, summary FROM Profile");
  if ( $stmt->rowCount() > 0){
    echo ("<tr><th>");
    echo ("<th>first_name</th>");
    echo ("<th>last_name</th>");
    echo("<th>email</th>");
    echo("<th>headline</th>");
    echo("<th>summary</th>");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo(htmlentities($row['first_name']));
        echo("</td><td>");
        echo(htmlentities($row['last_name']));
        echo("</td><td>");
        echo(htmlentities($row['email']));
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td><td>");
        echo(htmlentities($row['summary']));
        echo("</td><td>");
        echo('<a href="edit.php?autos_id='.$row['user_id'].'">Edit</a> / ');
        echo('<a href="delete.php?autos_id='.$row['user_id'].'">Delete</a>');
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
