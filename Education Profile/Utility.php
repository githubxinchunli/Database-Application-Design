<?php
function checkLogin(){
    if ( ! isset($_SESSION['user_id']) ) {
        die('ACCESS DENIED');
    }
}

function flashMessages(){
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }

    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
}

function validateProfile(){
    if ( strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 || strlen($_POST['email'])<1 ||
        strlen($_POST['headline'])<1 || strlen($_POST['summary'])<1) {
        return 'All fields are required';
    }
    if (strpos($_POST['email'], '@') === false) {
        return 'Email must have an at-sign (@)';
    }
    return true;
}

function validatePos(){
    for( $i=1; $i<9; $i++){
        if (!isset($_POST['year'.$i])) continue;
        if (!isset($_POST['desc'.$i])) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        if (strlen($year)<1 || strlen($desc)<1){
            return 'All fields are required';
        }
        if (!is_numeric($year)){
            return 'Position year must be numeric';
        }
    }
    return true;
}

function validateEdu(){
    for( $i=1; $i<9; $i++){
        if (!isset($_POST['edu_year'.$i])) continue;
        if (!isset($_POST['edu_school'.$i])) continue;
        $year = $_POST['edu_year'.$i];
        $school = $_POST['edu_school'.$i];
        if (strlen($year)<1 || strlen($school)<1){
            return 'All fields are required';
        }
        if (!is_numeric($year)){
            return 'Education year must be numeric';
        }
    }
    return true;
}

function loadPos($pdo, $profile_id){
    $stmt = $pdo->prepare('SELECT * FROM Position WHERE profile_id = :prof ORDER BY rank');
    $stmt -> execute(array(':prof'=>$profile_id));
    $positions = array();
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        $positions[] = $row;
    }
    return $positions;
}

function loadEdu($pdo, $profile_id){
    $stmt = $pdo->prepare('SELECT year, name FROM Education JOIN Institution ON Education.institution_id = Institution.institution_id WHERE profile_id = :prof ORDER BY rank');
    $stmt -> execute(array(':prof'=>$profile_id));
    $educations = array();
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        $educations[] = $row;
    }
    return $educations;
}