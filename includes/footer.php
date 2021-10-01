 <!--Copyright-->
 <div class="footer-copyright py-3 text-center">
      <!-- <div class="container-fluid">
        © 2019 Copyright: <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> MDBootstrap.com </a>
      </div> -->
    </div>
    <!--Copyright-->

  </footer>
  <!--Footer-->

  <!--SCRIPTS-->
  <script type="text/javascript" src="js/code.js"></script>

  <!--JQuery-->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

  <!--Bootstrap tooltips-->
  <script type="text/javascript" src="js/popper.min.js"></script>

  <!--Bootstrap core JavaScript-->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <!--MDB core JavaScript-->
  <script type="text/javascript" src="js/mdb.min.js"></script>

  <script>
    //Animation init
    new WOW().init();

    //Modal
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
    })

    // Material Select Initialization
    $(document).ready(function () {
      $('.mdb-select').material_select();
    });

  </script>

</body>

</html>
