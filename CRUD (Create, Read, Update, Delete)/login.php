<?php
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

session_start();
if(isset($_POST['submit'])){
    $salted_attempt = hash('md5', $salt.$_POST['pass']);

    if(strlen($_POST['email']) === 0 or strlen($_POST['pass']) === 0){
        $_SESSION['error'] = 'User name and password are required';
        header("Location: login.php");
        return;
    }
    elseif(strpos($_POST['email'],'@') == false){
        error_log("Login fail ".$_POST['email'].$_POST['pass']);
        $_SESSION['error'] = 'Email must have an at-sign (@)';
        header("Location: login.php");
        return;
    }
    elseif($salted_attempt !== $stored_hash){
        error_log("Login fail ".$_POST['email'].$_POST['pass']);
        $_SESSION['error'] = 'Incorrect password';
        header("Location: login.php");
        return;
    }
    else{
        error_log("Login success ".$_POST['email']);
        $_SESSION['name'] = $_POST['email'];
        header("Location: index.php");
        return;
    }
}

if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}

?>

<!DOCTYPE html>
<head>
  <title>Xinchun Li - Autos Database Login</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<body>
    <h1>Please Log In</h1>
    <form method="post">
    <?php
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
        <label for="who">User Name</label>
        <input type="text" name="email" id="email"><br/>
        <label for="pass">Password</label>
        <input type="text" name="pass" id="pass"><br/><br/>

        <input type="submit" name="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>