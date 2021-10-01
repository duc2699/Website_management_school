<?php include "includes/headerTopic.php" ?>

<!--Navigation & Intro-->
<header>

    <!--Navbar-->
    <?php include "includes/navigation.php" ?>
    <!--Navbar-->

    <!-- Intro Section -->
    <div id="home" class="view jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('/public/images/pngtree-welcome-back-to-school-background-image_389856.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="mask rgba-black-strong">
            <div class="container h-100 d-flex justify-content-center align-items-center">
                <div class="row smooth-scroll">
                    <div class="col-md-12 white-text text-center">
                        <div class="wow fadeInDown" data-wow-delay="0.2s">
                            <h2 class="display-3 font-weight-bold mb-2">GU's Articles</h2>
                            <hr class="hr-light">
                            <h3 class="subtext-header mt-4 mb-5">Where you can unleash your creativity and express
                                yourself through amazing article</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>
<!--Navigation & Intro-->

<!--Main content-->
<main>
    <div class="container">
        <section id="info" class="mt-4 mb-5 pb-4">
            <!--First row-->
            <div class="row wow fadeIn" data-wow-delay="0.4s">
                <!--First column-->
                <div class="col-md-12">
                    <div class="mb-2">
                        <!--Nav tabs-->
                        <ul class="nav md-pills pills-primary d-flex justify-content-center" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#panel" role="tab">
                                    <i class="fas fa-book-open fa-2x"></i>
                                    <br> All articles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#pane2" role="tab">
                                    <i class="far fa-newspaper fa-2x"></i>
                                    <br> Newest</a>
                            </li>
                        </ul>
                    </div>

                    <!--Tab panels-->
                    <div class="tab-content">
                        <!--Panel 1-->
                        <div class="tab-pane fade in show active" id="panel" role="tabpanel">
                            <br>
                            <div class="row wrapper__article mb-4">
                                <?php
                                    
                                ?>
                                <div class="col-lg-5 col-md-12 p-0 m-0">
                                    <div></div>
                                    <div class="view overlay z-depth-1 mb-2">
                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Work/4-col/img%20%2841%29.jpg" class="rounded a" alt="sample image">
                                    </div>
                                </div>
                                <div class="wrapper__content-article col-lg-6 ml-lg-auto col-md-12 text-center text-md-left">
                                    <h4 class="mt-4 mb-4">Vietnam Literature</h4>
                                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Nemo animi soluta
                                        ratione
                                        quisquam, dicta ab cupiditate iure eaque? Repellendus voluptatum, magni
                                        impedit
                                        eaque delectus, beatae maxime temporibus maiores quibusdam quasi.Rem magnam
                                        ad
                                        perferendis iusto sint tempora ea voluptatibus iure, animi excepturi modi
                                        aut
                                        possimus in hic molestias repellendus illo ullam odit quia velit.
                                        <a href="#">Read more...</a>
                                    </p>

                                    <span class="article__author">Nguyễn Ngô Thành Phát</span>

                                    <p class="mt-2">Date uploaded: 21/2/2021</p>
                                </div>
                            </div>

                            <!-- Button show more -->
                            <div class="wrapper__btn-showmore">
                                <button class="bubbly-button">Show more</button>
                            </div>

                        </div>
                        <!--Panel 1-->

                        <!--Panel 4-->
                        <div class="tab-pane fade" id="pane2" role="tabpanel">
                            <br>
                            <div class="row wrapper__article mb-4">
                                <div class="col-lg-5 col-md-12 p-0 m-0">
                                    <div></div>
                                    <div class="view overlay z-depth-1 mb-2">
                                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Work/4-col/img%20%2841%29.jpg" class="rounded a" alt="sample image">
                                    </div>
                                </div>
                                <div class="wrapper__content-article col-lg-6 ml-lg-auto col-md-12 text-center text-md-left">
                                    <h4 class="mt-4 mb-4">Vietnam Literature</h4>
                                    <p class="text-muted mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Nemo animi soluta
                                        ratione
                                        quisquam, dicta ab cupiditate iure eaque? Repellendus voluptatum, magni
                                        impedit
                                        eaque delectus, beatae maxime temporibus maiores quibusdam quasi.Rem magnam
                                        ad
                                        perferendis iusto sint tempora ea voluptatibus iure, animi excepturi modi
                                        aut
                                        possimus in hic molestias repellendus illo ullam odit quia velit.
                                        <a href="#">Read more...</a>
                                    </p>

                                    <span class="article__author">Nguyễn Ngô Thành Phát</span>

                                    <p class="mt-2">Date uploaded: 21/2/2021</p>
                                </div>
                            </div>
                            <!-- Button show more -->
                            <div class="wrapper__btn-showmore">
                                <button class="bubbly-button">Show more</button>
                            </div>
                        </div>
                        <!--Panel 4-->
                    </div>
                    <!--Tab panels-->
                </div>
                <!--First column-->
            </div>
            <!--First row-->
        </section>
    </div>
</main>




<?php include "includes/footerTopic.php" ?>