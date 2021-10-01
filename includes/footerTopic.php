<!--Footer-->
<footer class="page-footer text-center text-md-left mdb-color darken-3">

  <!--Footer Links-->
  <div class="container-fluid">

    <!--First row-->
    <div class="row " data-wow-delay="0.2s">

      <!--First column-->
      <div class="col-md-12 text-center mb-3 mt-3">

        <!--Icon-->
        <i class="fas fa-graduation-cap fa-4x orange-text"></i>
        <!--Title-->
        <h2 class="mt-3 mb-3">Join Us</h2>
        <!--Description-->
        <p class="white-text mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
          tempor
          incididunt ut labore et
          dolore magna aliqua.</p>
        <!--Reservation button-->

      </div>
      <!--First column-->

      <hr class="w-100 mt-4 mb-5">

    </div>
    <!--First row-->

    <div class="container mb-1">

      <!--Second row-->
      <div class="row">

        <!--First column-->
        <div class="col-xl-4 col-lg-4 pt-1 pb-1">
          <!--About-->
          <h5 class="text-uppercase mb-3 font-weight-bold">ABOUT SCHOOL</h5>

          <!--About-->

          <div class="footer-socials mt-4">

            <!--Facebook-->
            <a type="button" class="btn-floating btn-blue-2 ">
              <i class="fab fa-facebook-f"></i>
            </a>
            <!--Dribbble-->
            <a type="button" class="btn-floating btn-blue-2 ">
              <i class="fab fa-dribbble"></i>
            </a>
            <!--Twitter-->
            <a type="button" class="btn-floating btn-blue-2 ">
              <i class="fab fa-twitter"></i>
            </a>
            <!--Google +-->
            <a type="button" class="btn-floating btn-blue-2 ">
              <i class="fab fa-google-plus-g"></i>
            </a>

          </div>
        </div>
        <!--First column-->

        <hr class="w-100 clearfix d-lg-none">

        <!--Second column-->
        <div class="col-xl-3 ml-lg-auto col-lg-4 col-md-6 mt-1 mb-1">
          <!--Search-->
          <h5 class="text-uppercase mb-3 font-weight-bold">Search something</h5>

          <ul class="footer-search list-unstyled">
            <li>
              <form class="search-form" role="search">
                <div class="md-form">
                  <input type="text" class="form-control" placeholder="Search">
                </div>
              </form>
            </li>
          </ul>

          <!--Info-->
          <p>
            <i class="fas fa-home pr-1"></i> New York, NY 10012, US
          </p>
          <p>
            <i class="fas fa-envelope pr-1"></i> info@example.com
          </p>
          <p>
            <i class="fas fa-phone pr-1"></i> + 01 234 567 88
          </p>
          <p>
            <i class="fas fa-print pr-1"></i> + 01 234 567 89
          </p>

        </div>
        <!--Second column-->

        <hr class="w-100 clearfix d-md-none">

        <!--Third column-->
        <div class="col-xl-3 ml-lg-auto col-lg-4 col-md-6 mt-1 mb-1">
          <!--Contact-->
          <h5 class="text-uppercase mb-3 font-weight-bold">Recent news</h5>

          <ul class="footer-posts list-unstyled">
            <li>
              <a>Ut enim ad minim veniam nostrud.</a>
              <span>
                <p class="grey-text">28 july 2016</p>
              </span>
            </li>
            <li>
              <a>Duis aute dolor in reprehenderit.</a>
              <span>
                <p class="grey-text">27 july 2016</p>
              </span>
            </li>
            <li>
              <a>Excepteur sint occaecat cupidatat.</a>
              <span>
                <p class="grey-text">26 july 2016</p>
              </span>
            </li>
            <li>
              <a>Sed perspiciatis unde omnis iste.</a>
              <span>
                <p class="grey-text">25 july 2016</p>
              </span>
            </li>
          </ul>

        </div>
        <!--Third column-->

      </div>
      <!--Second row-->

    </div>

  </div>
  <!--Footer Links-->

</footer>
<!--Footer-->

<!--SCRIPTS-->
<script type="text/javascript" src="./js/code.js"></script>

<!--JQuery-->
<script type="text/javascript" src="./js/jquery-3.4.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<!--Bootstrap tooltips-->
<script type="text/javascript" src="./js/popper.min.js"></script>

<!--Bootstrap core JavaScript-->
<script type="text/javascript" src="./js/bootstrap.min.js"></script>

<!--MDB core JavaScript-->
<script type="text/javascript" src="./js/mdb.min.js"></script>

<script>
  //Animation init
  new WOW().init();

  //Modal
  $('#myModal').on('shown.bs.modal', function() {
    $('#myInput').focus()
  })

  // Material Select Initialization
  $(document).ready(function() {
    $('.mdb-select').material_select();
  });
</script>



</body>

</html>