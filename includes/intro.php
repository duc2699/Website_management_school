<!-- Intro Section -->
<div id="home" class="view jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/67.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
    <div class="mask rgba-black-strong">
        <div class="container h-100 d-flex justify-content-center align-items-center">
            <div class="row smooth-scroll">
                <div class="col-md-12 white-text text-center">
                    <div class="wow fadeInDown" data-wow-delay="0.2s">
                        <h2 class="display-3 font-weight-bold mb-2">Greenwich University</h2>
                        <hr class="hr-light">
                        <h3 class="subtext-header mt-4 mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit deleniti
                            consequuntur.</h3>
                    </div>
                    <?php
                    if (!isset($_SESSION['username'])) {
                        echo
                        "<a href='./login.php'>
                            <button class='btn btn-info wow fadeInLeft'>
                                <span>Login</span>
                            </button>
                        </a>    ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>