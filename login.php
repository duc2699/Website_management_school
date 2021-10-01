<?php include "includes/header.php" ?>
<?php
 if (isset($_SESSION['username'])) {
    header('Location: ./index.php');
 }
 if(isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
} else {
    $error = "";
}
 date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
    <div class="login__page wow fadeInLeft">
    <i class="fas fa-book-open"></i>
    <i class="fas fa-pencil-alt"></i>
    <i class="far fa-newspaper"></i>
    <i class="fas fa-award"></i>
    <i class="fas fa-graduation-cap"></i>
    <i class="fas fa-rocket"></i>
    <i class="fas fa-star"></i>
        <form class="wrapper__form-login" action="includes/login.php" method="post">
            <div class="wrapper__autotext">
            <h3 style="font-weight:bold; color:#6679ff;" class="line-1 anim-typewriter mb-4">Greenwich University CMS</h3>
            </div>
            <h4 style="font-weight:bold" class="text-center mt-3 mb-5">Sign in </h4>
            <p><?php echo isset($error) ? $error : ' '?></p>
        <!-- <label class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum</label> -->
        <h6>Username</h6>
            <input class="form-control mb-3" name="username" type="text" required>
            <h6>Password</h6>
            <input class="form-control mb-4" name="password" type="password" required>
        <div class="text-center mt-4">
            <input type="submit" value="Login" name="login" class="btn btn-primary ">
        </div>
        </form>
    </div>

