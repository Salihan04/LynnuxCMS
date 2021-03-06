<!DOCTYPE html>
<!-- saved from url=(0071)file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap.htm -->
<?php

require '../util/PSIGrabber.php';

// Getting PSI data
$psi_grabber = new PSIGrabber();
$psi_data = PSIGrabber::grabData();
?>
<html lang="en">
    <head>
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="./template_files/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./template_files/dashboard.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./template_files/ie-emulation-modes-warning.js"></script>
    <script src="./template_files/parse-1.3.1.min.js"></script>
    <script src="autoRefresh.js"></script>
    <script src="./template_files/google-map.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style id="holderjs-style" type="text/css"></style>

  <style>
  #map_canvas {
    height: 500px;
    background-color: #CCC;
  }
  #info {
    width: 50px;
    height: 80px;
    overflow: hidden;
  }
  tr:hover { 
    color: blue;
    font-weight: bold;
    cursor: pointer;
  }
  td a { 
    display: block; 
    border: 10px solid black;
    padding: 16px; 
  }
  </style>


  <script>
    // PSI data
    var psi_data = {};
    <?
      foreach ($psi_data as $key => $value) {
        echo 'psi_data[\''. $key . '\'] = ' . $value . ';';
      }
    ?>

    var regno = 0;
    var map;

    var northLatLng;
    var southLatLng;
    var eastLatLng;
    var westLatLng;
    var centralLatLng;

    var northMarker;
    var southMarker;
    var eastMarker;
    var westMarker;
    var centralMarker;

    var northInfo;
    var southInfo;
    var eastInfo;
    var westInfo;
    var centralInfo;

    // Parses returned response and extracts
    // the title, links, and text of each news story.
    function weather(o) {
        var regions = ["North", "East", "South", "West", "Central"]
        var items = o.query.results.channel.item.forecast;
        var output = '';
        var no_items = items.length;
        // for(var i=0;i<no_items;i++){
        var region = regions[regno];
        var date = items[0].date;
        var day = items[0].day;
        var high = Math.round((items[0].high - 32) * 5 / 9);
        var low = Math.round((items[0].low - 32) * 5 / 9);
        var text = items[0].text;
        var icon = items[0].code;
        var latitude = o.query.results.channel.item.lat;
        var longitude = o.query.results.channel.item.long;
        output += "<p id='info'><img src=http://l.yimg.com/a/i/us/we/52/" + icon + ".gif height='30' width='30'><br/>H:" + high + "&degC"+"<br/>L:" + low + "&degC<br/>PSI : " + psi_data[region] + "</p>";
        // }
        // Place news stories in div tag

        map = initialize();

        switch (regno) {
            case 0:
              console.log(region + " latitude: " + latitude);
              console.log(region + " longitude: " + longitude);

              northLatLng = new google.maps.LatLng(latitude, longitude);
              northInfo = output;
                // document.getElementById(region).innerHTML = output;
                break;
            case 1:
              console.log(region + " latitude: " + latitude);
              console.log(region + " longitude: " + longitude);

              eastLatLng = new google.maps.LatLng(latitude, longitude);
              eastInfo = output;
                // document.getElementById(region).innerHTML = output;
                break;
            case 2:
              console.log(region + " latitude: " + latitude);
              console.log(region + " longitude: " + longitude);

              southLatLng = new google.maps.LatLng(latitude, longitude);
              southInfo = output;
                // document.getElementById(region).innerHTML = output;
                break;
            case 3:
              console.log(region + " latitude: " + latitude);
              console.log(region + " longitude: " + longitude);

              westLatLng = new google.maps.LatLng(latitude, longitude);
              westInfo = output;
                // document.getElementById(region).innerHTML = output;
                break;
            case 4:
              console.log(region + " latitude: " + latitude);
              console.log(region + " longitude: " + longitude);
                
              centralLatLng = new google.maps.LatLng(latitude, longitude);
              centralInfo = output;
                // document.getElementById(region).innerHTML = output;
                break;
        }
        regno = (regno + 1) % 5;
    }

    // For google map
    var map;

    function initialize() {
      var mapCanvas = document.getElementById('map_canvas');

      var mapOptions = {
        center: new google.maps.LatLng(1.3507023, 103.8500700),
        zoom: 11,
        disableZoom: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true
      }
      map = new google.maps.Map(mapCanvas, mapOptions);

      // var contentString = '<div id="content">' + '<h1>Hello</h1>' + '<div id="bodyContent">' + '<p>Hello World!</p>' + '</div>' + '<div>';

      var northInfoWindow = new google.maps.InfoWindow({
        content: northInfo
      });

      var eastInfoWindow = new google.maps.InfoWindow({
        content: eastInfo
      });

      var southInfoWindow = new google.maps.InfoWindow({
        content: southInfo
      });

      var westInfoWindow = new google.maps.InfoWindow({
        content: westInfo
      });

      var centralInfoWindow = new google.maps.InfoWindow({
        content: centralInfo
      });

      northMarker = new google.maps.Marker({
        position: northLatLng,
        map: map,
        title: "North"
      });

      eastMarker = new google.maps.Marker({
        position: eastLatLng,
        map: map,
        title: "East"
      });

      southMarker = new google.maps.Marker({
        position: southLatLng,
        map: map,
        title: "South"
      });

      westMarker = new google.maps.Marker({
        position: westLatLng,
        map: map,
        title: "West"
      });

      centralMarker = new google.maps.Marker({
        position: centralLatLng,
        map: map,
        title: "Central"
      });

      northInfoWindow.open(map, northMarker);
      eastInfoWindow.open(map, eastMarker);
      southInfoWindow.open(map, southMarker);
      westInfoWindow.open(map, westMarker);
      centralInfoWindow.open(map, centralMarker);

      // google.maps.event.addListener(northMarker, 'click', function() {
      //   northInfoWindow.open(map, northMarker);
      // });

      // google.maps.event.addListener(eastMarker, 'click', function() {
      //   eastInfoWindow.open(map, eastMarker);
      // });

      // google.maps.event.addListener(southMarker, 'click', function() {
      //   southInfoWindow.open(map, southMarker);
      // });

      // google.maps.event.addListener(westMarker, 'click', function() {
      //   westInfoWindow.open(map, westMarker);
      // });

      // google.maps.event.addListener(centralMarker, 'click', function() {
      //   centralInfoWindow.open(map, centralMarker);
      // });

      return map;
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>

</head>

  <body onload="Initializer.init();" >

    <?php
      include('menu/operator_top_menu.php');
    ?>

    <div class="container-fluid">
      <div class="row">
        <?php
          include('menu/operator_side_menu.php');
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Singapore Map</h1>

          <div class="row placeholders">
            <div id="map_canvas"></div>
          </div>

          <h2 class="sub-header">Incident</h2>
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="incident_table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th>Resources</th>
                </tr>
              </thead>
              <tbody id="incident_body">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./template_files/jquery.min.js"></script>
    <script src="./template_files/bootstrap.min.js"></script>
    <script src="./template_files/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./template_files/ie10-viewport-bug-workaround.js"></script>

    <!-- Yahoo Map API JavaScript
    ================================================== -->
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D1062668%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D1062494%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D24703053%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D1062460%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D24703032%0A&format=json&diagnostics=true&callback=weather'></script>
  
</object>
</div>
</body>
</html>