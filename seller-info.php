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
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/handlebars/4.7.7/handlebars.min.js"></script>
  <link href="src/css/bootstrap.min.css" rel="stylesheet">
  <link href="src/css/font-awesome.min.css?v=<?php echo time(); ?>" rel="stylesheet">
  <link href="src/css/main2.css?v=<?php echo time(); ?>" rel="stylesheet">

</head>
<style>
  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #map-container {
    width: 100%;
    height: 550px;
    position: relative;
    font-family: "Roboto", sans-serif;
    box-sizing: border-box;
  }

  #map-container a {
    text-decoration: none;
    color: #1967d2;
  }

  #map-container button {
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    font-size: inherit;
    cursor: pointer;
  }

  #gmp-map {
    position: absolute;
    left: 22em;
    top: 0;
    right: 0;
    bottom: 0;
  }

  #locations-panel {
    position: absolute;
    left: 0;
    width: 22em;
    top: 0;
    bottom: 0;
    overflow-y: auto;
    background: white;
    padding: 0.5em;
    box-sizing: border-box;
  }

  @media only screen and (max-width: 876px) {
    #gmp-map {
      left: 0;
      bottom: 50%;
    }

    #locations-panel {
      top: 50%;
      right: 0;
      width: unset;
    }
  }

  #locations-panel-list>header {
    padding: 1.4em 1.4em 0 1.4em;
  }

  #locations-panel-list h1.search-title {
    font-size: 1em;
    font-weight: 500;
    margin: 0;
  }

  #locations-panel-list h1.search-title>img {
    vertical-align: bottom;
    margin-top: -1em;
  }

  #locations-panel-list .search-input {
    width: 100%;
    margin-top: 0.8em;
    position: relative;
  }

  #locations-panel-list .search-input input {
    width: 100%;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.3em;
    height: 2.2em;
    box-sizing: border-box;
    padding: 0 2.5em 0 1em;
    font-size: 1em;
  }

  #locations-panel-list .search-input-overlay {
    position: absolute;
  }

  #locations-panel-list .search-input-overlay.search {
    right: 2px;
    top: 2px;
    bottom: 2px;
    width: 2.4em;
  }

  #locations-panel-list .search-input-overlay.search button {
    width: 100%;
    height: 100%;
    border-radius: 0.2em;
    color: black;
    background: transparent;
  }

  #locations-panel-list .search-input-overlay.search .icon {
    margin-top: 0.05em;
    vertical-align: top;
  }

  #locations-panel-list .section-name {
    font-weight: 500;
    font-size: 0.9em;
    margin: 1.8em 0 1em 1.5em;
  }

  #locations-panel-list .location-result {
    position: relative;
    padding: 0.8em 3.5em 0.8em 1.4em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    cursor: pointer;
  }

  #locations-panel-list .location-result:first-of-type {
    border-top: 1px solid rgba(0, 0, 0, 0.12);
  }

  #locations-panel-list .location-result:last-of-type {
    border-bottom: none;
  }

  #locations-panel-list .location-result.selected {
    outline: 2px solid #4285f4;
  }

  #locations-panel-list button.select-location {
    margin-bottom: 0.6em;
    text-align: left;
  }

  #locations-panel-list .location-result h2.name {
    font-size: 1em;
    font-weight: 500;
    margin: 0;
  }

  #locations-panel-list .location-result .address {
    font-size: 0.9em;
    margin-bottom: 0.5em;
  }

  #locations-panel-list .directions-button {
    position: absolute;
    right: 1.2em;
    top: 2.3em;
  }

  #locations-panel-list .directions-button-background:hover {
    fill: rgba(116, 120, 127, 0.1);
  }

  #locations-panel-list .directions-button-background {
    fill: rgba(255, 255, 255, 0.01);
  }

  #location-results-list {
    list-style-type: none;
    margin: 0;
    padding: 0;
  }
</style>

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
      <h2 class="text-center">Seller Information</h2>
      <div class="data">
        <div class="content-data" style="padding: 0px;">
          <div id="map-container">
            <div id="locations-panel">
              <div id="locations-panel-list">
                <header>
                  <div class="search-input">
                    <input id="location-search-input" placeholder="Enter your address or zip code">
                    <div id="search-overlay-search" class="search-input-overlay search">
                      <button id="location-search-button">
                        <img class="icon" src="https://fonts.gstatic.com/s/i/googlematerialicons/search/v11/24px.svg" alt="Search" />
                      </button>
                    </div>
                  </div>
                </header>
                <div class="section-name" id="location-results-section-name">
                  All locations
                </div>
                <div class="results">
                  <ul id="location-results-list"></ul>
                </div>
              </div>
            </div>
            <div id="gmp-map"></div>
          </div>
        </div>
      </div>
    </div>
    <br><br><br><br>
    <div class="container">
      <h2 class="text-center">Products</h2>
    </div>

    <div class="dashboard-data-products">


      <?php

      $admin_id = $_GET['Id'];

      $pdoQuery = "SELECT * FROM product_list WHERE admin_id=$admin_id AND product_status = :product_status ";
      $pdoResult3 = $pdoConnect->prepare($pdoQuery);
      $pdoExec = $pdoResult3->execute(array(":product_status" => "active"));
      $total_data = $pdoResult3->rowCount();

      if ($total_data > 0) {

        while ($product_data = $pdoResult3->fetch(PDO::FETCH_ASSOC)) {
          $product_image = $product_data['product_image'];

      ?>

          <div class="dashboard-card-products">
            <div class="list">
              <div>
                <img src="src/img/<?php echo $product_image ?>" alt="">
                <h1><?php echo $product_data['product_name']; ?></h1>
                <p><?php echo $product_data['product_descriptions']; ?></p>
                <p>Availability :</p>
                <?php

                if ($product_data['start_datetime'] == NULL || $product_data['end_datetime'] == NULL) {
                ?>
                  <p style="font-weight: bold; color: red;">Not Available</p>
                <?php

                } else {
                ?>
                  <p style="font-weight: bold;"><?php echo date("F d", strtotime($product_data['start_datetime'])) ?> to <?php echo date("F d, Y", strtotime($product_data['end_datetime'])) ?></p>
                <?php
                }
                ?>

                <label for="">₱ <?php echo $product_data['product_price']; ?> per kg.</label>
              </div>
            </div>
          </div>

        <?php
        }
      } else {
        ?>

        <div class="no-data-2">
          <h3>NO PRODUCTS AVAILABLE</h3>
        </div>
      <?php
      }
      ?>


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
  <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $GoogleAPI ?>&callback=initMap&libraries=places,geometry&solution_channel=GMP_QB_locatorplus_v6_cA" async defer></script>

  <script>
    'use strict';

    /** Helper function to generate a Google Maps directions URL */
    function generateDirectionsURL(origin, destination) {
      const googleMapsUrlBase = 'https://www.google.com/maps/dir/?';
      const searchParams = new URLSearchParams('api=1');
      searchParams.append('origin', origin);
      const destinationParam = [];
      // Add title to destinationParam except in cases where Quick Builder set
      // the title to the first line of the address
      if (destination.title !== destination.address1) {
        destinationParam.push(destination.title);
      }
      destinationParam.push(destination.address1, destination.address2);
      searchParams.append('destination', destinationParam.join(','));
      return googleMapsUrlBase + searchParams.toString();
    }

    /**
     * Defines an instance of the Locator+ solution, to be instantiated
     * when the Maps library is loaded.
     */
    function LocatorPlus(configuration) {
      const locator = this;

      locator.locations = configuration.locations || [];
      locator.capabilities = configuration.capabilities || {};

      const mapEl = document.getElementById('gmp-map');
      const panelEl = document.getElementById('locations-panel');
      locator.panelListEl = document.getElementById('locations-panel-list');
      const sectionNameEl =
        document.getElementById('location-results-section-name');
      const resultsContainerEl = document.getElementById('location-results-list');

      const itemsTemplate = Handlebars.compile(
        document.getElementById('locator-result-items-tmpl').innerHTML);

      locator.searchLocation = null;
      locator.searchLocationMarker = null;
      locator.selectedLocationIdx = null;
      locator.userCountry = null;

      // Initialize the map -------------------------------------------------------
      locator.map = new google.maps.Map(mapEl, configuration.mapOptions);

      // Store selection.
      const selectResultItem = function(locationIdx, panToMarker, scrollToResult) {
        locator.selectedLocationIdx = locationIdx;
        for (let locationElem of resultsContainerEl.children) {
          locationElem.classList.remove('selected');
          if (getResultIndex(locationElem) === locator.selectedLocationIdx) {
            locationElem.classList.add('selected');
            if (scrollToResult) {
              panelEl.scrollTop = locationElem.offsetTop;
            }
          }
        }
        if (panToMarker && (locationIdx != null)) {
          locator.map.panTo(locator.locations[locationIdx].coords);
        }
      };

      // Create a marker for each location.
      const markers = locator.locations.map(function(location, index) {
        const marker = new google.maps.Marker({
          position: location.coords,
          map: locator.map,
          title: location.title,
        });
        marker.addListener('click', function() {
          selectResultItem(index, false, true);
        });
        return marker;
      });

      // Fit map to marker bounds.
      locator.updateBounds = function() {
        const bounds = new google.maps.LatLngBounds();
        if (locator.searchLocationMarker) {
          bounds.extend(locator.searchLocationMarker.getPosition());
        }
        for (let i = 0; i < markers.length; i++) {
          bounds.extend(markers[i].getPosition());
        }
        locator.map.fitBounds(bounds);
      };
      if (locator.locations.length) {
        locator.updateBounds();
      }

      // Get the distance of a store location to the user's location,
      // used in sorting the list.
      const getLocationDistance = function(location) {
        if (!locator.searchLocation) return null;

        // Fall back to straight-line distance.
        return google.maps.geometry.spherical.computeDistanceBetween(
          new google.maps.LatLng(location.coords),
          locator.searchLocation.location);
      };

      // Render the results list --------------------------------------------------
      const getResultIndex = function(elem) {
        return parseInt(elem.getAttribute('data-location-index'));
      };

      locator.renderResultsList = function() {
        let locations = locator.locations.slice();
        for (let i = 0; i < locations.length; i++) {
          locations[i].index = i;
        }
        if (locator.searchLocation) {
          sectionNameEl.textContent =
            'Nearest locations (' + locations.length + ')';
          locations.sort(function(a, b) {
            return getLocationDistance(a) - getLocationDistance(b);
          });
        } else {
          sectionNameEl.textContent = `All locations (${locations.length})`;
        }
        const resultItemContext = {
          locations: locations
        };
        resultsContainerEl.innerHTML = itemsTemplate(resultItemContext);
        for (let item of resultsContainerEl.children) {
          const resultIndex = getResultIndex(item);
          if (resultIndex === locator.selectedLocationIdx) {
            item.classList.add('selected');
          }

          const resultSelectionHandler = function() {
            if (resultIndex !== locator.selectedLocationIdx) {
              selectResultItem(resultIndex, true, false);
            }
          };

          // Clicking anywhere on the item selects this location.
          // Additionally, create a button element to make this behavior
          // accessible under tab navigation.
          item.addEventListener('click', resultSelectionHandler);
          item.querySelector('.select-location')
            .addEventListener('click', function(e) {
              resultSelectionHandler();
              e.stopPropagation();
            });

          // Clicking the directions button will open Google Maps directions in a
          // new tab
          const origin = (locator.searchLocation != null) ?
            locator.searchLocation.location :
            '';
          const destination = locator.locations[resultIndex];
          const googleMapsUrl = generateDirectionsURL(origin, destination);
          item.querySelector('.directions-button')
            .setAttribute('href', googleMapsUrl);
        }
      };

      // Optional capability initialization --------------------------------------
      initializeSearchInput(locator);

      // Initial render of results -----------------------------------------------
      locator.renderResultsList();
    }

    /** When the search input capability is enabled, initialize it. */
    function initializeSearchInput(locator) {
      const geocodeCache = new Map();
      const geocoder = new google.maps.Geocoder();

      const searchInputEl = document.getElementById('location-search-input');
      const searchButtonEl = document.getElementById('location-search-button');

      const updateSearchLocation = function(address, location) {
        if (locator.searchLocationMarker) {
          locator.searchLocationMarker.setMap(null);
        }
        if (!location) {
          locator.searchLocation = null;
          return;
        }
        locator.searchLocation = {
          'address': address,
          'location': location
        };
        locator.searchLocationMarker = new google.maps.Marker({
          position: location,
          map: locator.map,
          title: 'My location',
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 12,
            fillColor: '#3367D6',
            fillOpacity: 0.5,
            strokeOpacity: 0,
          }
        });

        // Update the locator's idea of the user's country, used for units. Use
        // `formatted_address` instead of the more structured `address_components`
        // to avoid an additional billed call.
        const addressParts = address.split(' ');
        locator.userCountry = addressParts[addressParts.length - 1];

        // Update map bounds to include the new location marker.
        locator.updateBounds();

        // Update the result list so we can sort it by proximity.
        locator.renderResultsList();
      };

      const geocodeSearch = function(query) {
        if (!query) {
          return;
        }

        const handleResult = function(geocodeResult) {
          searchInputEl.value = geocodeResult.formatted_address;
          updateSearchLocation(
            geocodeResult.formatted_address, geocodeResult.geometry.location);
        };

        if (geocodeCache.has(query)) {
          handleResult(geocodeCache.get(query));
          return;
        }
        const request = {
          address: query,
          bounds: locator.map.getBounds()
        };
        geocoder.geocode(request, function(results, status) {
          if (status === 'OK') {
            if (results.length > 0) {
              const result = results[0];
              geocodeCache.set(query, result);
              handleResult(result);
            }
          }
        });
      };

      // Set up geocoding on the search input.
      searchButtonEl.addEventListener('click', function() {
        geocodeSearch(searchInputEl.value.trim());
      });


      // Add in an event listener for the Enter key.
      searchInputEl.addEventListener('keypress', function(evt) {
        if (evt.key === 'Enter') {
          geocodeSearch(searchInputEl.value);
        }
      });
    }
  </script>
  <script>
    var x = document.getElementById("demo");

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
      x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;
    }

    <?php
    $latitude_data = '<script>document.writeln(position.coords.latitude);</script>';
    $longitude_data = '<script>document.writeln(position.coords.latitude);</script>'
    ?>


    const CONFIGURATION = {
      "locations": [

        <?php

        $userId = $_GET['Id'];
        $pdoQuery = "SELECT * FROM admin WHERE userId = :userId";
        $pdoResult = $pdoConnect->prepare($pdoQuery);
        $pdoExec = $pdoResult->execute(array(":userId" => $userId));
        while ($admin_profile = $pdoResult->fetch(PDO::FETCH_ASSOC)) {

          $business_name    = $admin_profile["business_name"];
          $address          = $admin_profile["address"];
          $latitude         = $admin_profile["latitude"];
          $longitude        = $admin_profile["longitude"];
          $admin_id         = $admin_profile['userId'];

        ?> {
            "title": "<?php echo $business_name ?>",
            "address1": "<?php echo $address ?>",
            "adminId": "<?php echo $admin_id ?>",
            "coords": {
              "lat": <?php echo $latitude ?>,
              "lng": <?php echo $longitude ?>
            }
          },

        <?php
        }
        ?>

      ],

      "mapRadius": 5000,
      "mapOptions": {
        "center": {
          "lat": 14.8534572,
          "lng": 120.5167547
        },
        "fullscreenControl": true,
        "mapTypeControl": true,
        "streetViewControl": true,
        "zoom": 4,
        "zoomControl": true,
        "maxZoom": 17,
        "mapId": "",
      },
      "mapsApiKey": "<?php echo $GoogleAPI ?>",
      "capabilities": {
        "input": true,
        "autocomplete": false,
        "directions": false,
        "distanceMatrix": false,
        "details": false,
        "actions": false
      }
    };

    function initMap() {
      new LocatorPlus(CONFIGURATION);
    }
  </script>
  <script id="locator-result-items-tmpl" type="text/x-handlebars-template">
    {{#each locations}}
      <li class="location-result" data-location-index="{{index}}">
        <button class="select-location" style="display:flex;">
          <h2 class="name">{{title}}</h2>
        </button>
        <div class="address">{{address1}}<br>{{address2}}</div>
        <a class="directions-button" href="" target="_blank" title="Get directions to this location on Google Maps">
          <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.5867 9.24375L17.9403 8.8902V8.8902L17.5867 9.24375ZM16.4117 9.24375L16.7653 9.59731L16.7675 9.59502L16.4117 9.24375ZM8.91172 16.7437L8.55817 16.3902L8.91172 16.7437ZM8.91172 17.9229L8.55817 18.2765L8.55826 18.2766L8.91172 17.9229ZM16.4117 25.4187H16.9117V25.2116L16.7652 25.0651L16.4117 25.4187ZM16.4117 25.4229H15.9117V25.63L16.0582 25.7765L16.4117 25.4229ZM25.0909 17.9229L25.4444 18.2765L25.4467 18.2742L25.0909 17.9229ZM25.4403 16.3902L17.9403 8.8902L17.2332 9.5973L24.7332 17.0973L25.4403 16.3902ZM17.9403 8.8902C17.4213 8.3712 16.5737 8.3679 16.0559 8.89248L16.7675 9.59502C16.8914 9.4696 17.1022 9.4663 17.2332 9.5973L17.9403 8.8902ZM16.0582 8.8902L8.55817 16.3902L9.26527 17.0973L16.7653 9.5973L16.0582 8.8902ZM8.55817 16.3902C8.0379 16.9105 8.0379 17.7562 8.55817 18.2765L9.26527 17.5694C9.13553 17.4396 9.13553 17.227 9.26527 17.0973L8.55817 16.3902ZM8.55826 18.2766L16.0583 25.7724L16.7652 25.0651L9.26517 17.5693L8.55826 18.2766ZM15.9117 25.4187V25.4229H16.9117V25.4187H15.9117ZM16.0582 25.7765C16.5784 26.2967 17.4242 26.2967 17.9444 25.7765L17.2373 25.0694C17.1076 25.1991 16.895 25.1991 16.7653 25.0694L16.0582 25.7765ZM17.9444 25.7765L25.4444 18.2765L24.7373 17.5694L17.2373 25.0694L17.9444 25.7765ZM25.4467 18.2742C25.9631 17.7512 25.9663 16.9096 25.438 16.3879L24.7354 17.0995C24.8655 17.2279 24.8687 17.4363 24.7351 17.5716L25.4467 18.2742Z" fill="#57b846" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M19 19.8333V17.75H15.6667V20.25H14V16.9167C14 16.4542 14.3708 16.0833 14.8333 16.0833H19V14L21.9167 16.9167L19 19.8333Z" fill="#57b846" />
            <circle class="directions-button-background" cx="17" cy="17" r="16.5" stroke="#57b846" />
          </svg>
        </a>
      </li>
    {{/each}}
  </script>
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