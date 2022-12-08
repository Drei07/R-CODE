<?php
include_once __DIR__ . '/src/API/api.php';
include_once 'user/authentication/user-signin.php';
include_once 'dashboard/superadmin/controller/select-settings-configuration-controller.php';

?>
<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FISHBOOK</title>
  <link rel="shortcut icon" href="src/img/<?php echo $logo ?>">
  <link rel="stylesheet" type="text/css" href="src/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="src/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link href="src/css/bootstrap.min.css" rel="stylesheet">
  <link href="src/css/font-awesome.min.css?v=<?php echo time(); ?>" rel="stylesheet">
  <link href="src/css/main2.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>

<body>
  <!--main-->
  <section class="main">
    <div class="overlay" style="	background: url(src/img/fisherman.jpeg) center center no-repeat fixed; background-size: cover;"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <!--logo-->
          <div class="logo"><img src="src/img/<?php echo $logo ?>" width="50px" alt="logo">&nbsp;&nbsp;&nbsp;FISHBOOK</div>
          <!--logo end-->
        </div>
        <div class="col-md-6 col-sm-6">

          <!--social-->
          <div class="social text-center">
            <ul>
              <li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a></li>
              <li><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://plus.google.com/" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            </ul>
          </div>
          <!--social end-->
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!--welcome-message-->
          <header class="welcome-message text-center">
            <h1><span class="rotate">We Are Launching Soon , FISHBOOK , ONLINE FISHERIES SUPPLIER RECOMMENDER SYSTEM</span></h1>
          </header>
          <!--welcome-message end-->

          <!--sub-form-->
          <div class="sub-form text-center">
            <div class="row">
              <div class="col-md-5 center-block col-sm-8 col-xs-11">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" data-bs-toggle="modal" data-bs-target="#classModal" style="border-radius:10px;">Search</button>
                  </span>
                </div>
                <p id="mc-notification"></p>
              </div>
            </div>
          </div>
          <!--sub-form end-->

          <!-- Countdown-->
          <ul class="countdown text-center">

          </ul>
          <!-- Countdown end-->

        </div>
      </div>
    </div>
  </section>
  <!--main end-->

  <!--Features-->

  <section class="features section-spacing">
    <div class="container">
      <h2 class="text-center">Featered services</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="wow fadeInUp product-features row">
            <div class="col-md-2 col-sm-2 col-xs-2 text-center"><i class="fa fa-search fa-3x"></i></div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <!--features 3-->
              <h4>Recommender</h4>
              <p> A web-based system that will recommend the supplier of fishery based from the user location.</p>
              <!--features 3 end-->
            </div>
          </div>
          <div class="wow fadeInUp product-features row">
            <div class="col-md-2 col-sm-2 col-xs-2 text-center"><i class="fa fa-map fa-3x"></i></div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <!--features 4-->
              <h4>Google Maps</h4>
              <p>By the use of google maps API. customer can see the exact location of supplier.</p>
              <!--features 4 end-->
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="wow fadeInUp product-features row">
            <div class="col-md-2 col-sm-2 col-xs-2 text-center"><i class="fa fa-calendar fa-3x"></i></div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <!--features 3-->
              <h4>Availability</h4>
              <p>Customer can see the products availability using calendar to be Maximize conversion through an aggregated, real-time, accurate view of inventory.</p>
              <!--features 3 end-->
            </div>
          </div>
          <div class="wow fadeInUp product-features row">
            <div class="col-md-2 col-sm-2 col-xs-2 text-center"><i class="fa fa-shopping-cart fa-3x"></i></div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <!--features 4-->
              <h4>Fish Products</h4>
              <p>A web-based system that seller can input dynamic fishery products as many they want.</p>
              <!--features 4 end-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="class-modal">
    <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="height: 700px;">
          <div class="header"></div>
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <section class="data-table">
              <div class="searchBx">
                <input type="input" placeholder="search vendor. . . . . " class="search numbers" inputmode="numeric" name="search_box" id="search_box"><button class="searchBtn"><i class="fa fa-search" style="color: #FFF;"></i></button>
              </div>

              <div class="table">
                <div id="student-data">
                </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--CONTACT END-->

  <!--site-footer-->
  <footer class="site-footer section-spacing">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">

          <!--social-->

          <ul class="social">
            <li class="wow fadeInUp"><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li class="wow fadeInUp"><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li class="wow fadeInUp"><a href="https://plus.google.com/" target="_blank"><i class="fa fa-google-plus"></i></a></li>
          </ul>

          <!--social end-->

          <small class="wow fadeInUp"><?php echo $system_copyright ?><i class="fa fa-heart pulse"></i>
        </div>
      </div>
    </div>
  </footer>
  <!--site-footer end-->

  <!--PRELOAD-->
  <div id="preloader">
    <div id="status"></div>
  </div>
  <!--end PRELOAD-->
  <script src="src/js/jquery-1.11.1.min.js"></script>
  <script src="src/js/jquery.backstretch.min.js"></script>
  <script src="src/js/wow.min.js"></script>
  <script src="src/js/retina.min.js"></script>
  <script src="src/js/tweetie.min.js"></script>
  <script src="src/js/jquery.downCount.js"></script>
  <script src="src/js/jquery.form.min.js"></script>
  <script src="src/js/jquery.validate.min.js"></script>
  <script src="src/js/jquery.simple-text-rotator.min.js"></script>
  <script src="src/js/main.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
  <script src="src/js/gmap.js"></script>
  <script src="src/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    //live search---------------------------------------------------------------------------------------//
    $(document).ready(function() {

      load_data(1);

      function load_data(page, query = '') {
        $.ajax({
          url: "seller-data-table.php",
          method: "POST",
          data: {
            page: page,
            query: query
          },
          success: function(data) {
            $('#student-data').html(data);
          }
        });
      }

      $(document).on('click', '.page-link', function() {
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
      });

      $('#search_box').keyup(function() {
        var query = $('#search_box').val();
        load_data(1, query);
      });

    });
  </script>
</body>

</html>