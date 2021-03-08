<?php require 'functions.php';
$login=$_POST['login'];
$pass= $_POST['password'];
if(empty($login) || empty($pass)) {
    sendError("Input fields shouldn't be empty");
    exit;
}
$user=searchInDB($login, $pass);
$users=getUsers();
if($user){
    session_start();
    $_SESSION['users'] = $user;
    header("Location: news.php");
}
else{
    echo "User not found<br>";
}?>
	