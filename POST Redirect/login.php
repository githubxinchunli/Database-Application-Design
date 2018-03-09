<?php 

// use session
session_start();


// login information
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123



// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
	    $check = hash('md5', $salt.$_POST['pass']);
	    if ( strlen($_POST['pass']) < 1 || strlen($_POST['email']) < 1 ) {
		    $_SESSION['error'] = "Email and password are required";
			error_log("Login fail ".$_POST['email']." $check");
	    }
	    elseif(strpos($_POST['email'], '@') == false){
		    $_SESSION['error'] = "Email must have an at-sign (@)";
		    
		    error_log("Login fail ".$_POST['email']." $check");
		}
	    else {
		if ( $check == $stored_hash ) {
		    $_SESSION['name'] = $_POST['email'];
		    header("Location: view.php");
		    error_log("Login success ".$_POST['email']);
		    return;
		} else {
		    $_SESSION['error'] = "Incorrect password";
		    error_log("Login fail ".$_POST['email']." $check");
		}
    }

    header("Location: login.php");
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Xinchun Li bd853b47</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php


if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}

?>
<form method="POST">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">


</form>
<p>
	For a password hint, view source and find a password hint
	in the HTML comments.

</p>
</div>
</body>
</html>
