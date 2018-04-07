<?php
$salt = 'XyZzy12*_';

$check = hash('md5', $salt.$_POST['pass']);
$stmt = $pdo->prepare('SELECT user_id, name FROM users
    WHERE email = :em AND password = :pw');
$stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


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
        $_SESSION['error'] = 'Email must have @';
        header("Location: login.php");
        return;
    }
    elseif($row === false){
        error_log("Login fail ".$_POST['email'].$_POST['pass']);
        $_SESSION['error'] = 'Incorrect password';
        header("Location: login.php");
        return;
    }
    else{( $row !== false ) {
    $_SESSION['name'] = $row['name'];
    $_SESSION['user_id'] = $row['user_id'];
    // Redirect the browser to index.php
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
  <title>Xinchun Li - JavaScript</title>
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
    <script type="text/javascript">
    // validation of user login
    function doValidate() {
    console.log('Validating...');
    try {
        pw = document.getElementById('id_1723').value;
        console.log("Validating pw="+pw);
        if (pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
    try {
        em = document.getElementById('email').value;
        console.log("Validating em="+em);
        if (strpos(em,'@') == false) {
            alert("Email address must contain @");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
} 
</script>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
        <label for="who">User Name</label>
        <input type="text" name="email" id="email"><br/>
        <label for="pass">Password</label>
        <input type="password" name="pass" id="id_1723"><br/><br/>

        <input type="submit" onclick = "return doValidate();" name="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>