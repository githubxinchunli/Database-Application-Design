<?php
require_once "pdo.php";
session_start();

if(isset($_POST['submit'])){
    if(strpos($_POST['email'],'@') == false){
        // error_log("Login fail ".$_POST['email'].$_POST['pass']);
        $_SESSION['error'] = 'Email address must contain @';
        header("Location: login.php");
        return;
    }
    else{
        $salt = 'XyZzy12*_';
        $salted_attempt = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $salted_attempt));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
            return;
        }
        else{
            $_SESSION['error'] = 'Invalid email or incorrect password';
            header("Location: login.php");
            return;
        }
    }
}

?>

<!DOCTYPE html>
<head>
  <title>Xinchun Li's Resume Registry - login page</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<body>
    <h1>Please log in</h1>
    <form method="post">
        <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <p>Email:
            <input type="text" id="email" name="email"/></p>
        <p>Password:
            <input type="password" id="pass" name="pass"/></p>
        <p><input type="submit" name="submit" value="Log In" onclick="validate()"/></p>
        <p><input type="button" name="cancel" value="Cancel" onclick="location.href='index.php'"/></p>
    </form>
<script type="text/javascript">
    function validate() {
        console.log('Validating...');
        try {
            em = document.getElementById('email').value;
            pw = document.getElementById('pass').value;
            console.log("Validating email=" + em);
            console.log("Validating password=" + pw);
            if (em == null || em == "" || pw == null || pw == "") {
                alert("Both fields must be filled out");
                return false;
            }
            else if (!(em.includes("@"))) {
                alert("Email address must contain @");
                return false;
            }
            return true;
        } catch(e) {
            return false;
        }
    }
</script>
</body>
</html>