<?php ob_start(); ?>
<?php session_start(); ?>

<?php
$_SESSION['user_id']        =   null;
$_SESSION['username']       =   null;
$_SESSION['password']       =   null;
$_SESSION['fullname']       =   null;
$_SESSION['user_email']     =   null;
$_SESSION['user_role']      =   null;
$_SESSION['user_faculty']   =   null;
$_SESSION['user_image']     =   null;

header("Location: ../index.php");
?>