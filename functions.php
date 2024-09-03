<?php
require('./db/DBController.php');
require('./db/position.php');
require('./db/candidate.php');
$db = new DBController();
$position = new Positon($db);
$candidate = new Candidate($db);
$restrict_page = function () {
    //user is not logged-in
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //if user is not logged in we are going to redirect it to the login page
    if ($_SESSION['logged-in'] == 'no') {
        header('Location:login.php?session');
        exit();
    }
    //if the user is logged in but is not admin
    else if( $_SESSION['is_admin'] == 'no'){
        header('Location:voter.php');
        exit();
    }
};
