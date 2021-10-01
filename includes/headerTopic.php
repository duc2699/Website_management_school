<?php ob_start(); ?>
<?php session_start();?>
<?php include "functions.php"?>
<!DOCTYPE html>
<html lang="en">

<?php
    if (!isset($_SESSION['user_role'])) {
        header('Location: ./index.php');
    }
    if (isset($_SESSION['user_faculty'])) {
        if(($_SESSION['user_faculty']) == 'No Faculty') 
        {
            header('Location: ./index.php');
        }
    }
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Topic details</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="./css/mdb.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/responsive.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
</head>

<body>