<!DOCTYPE html>
<!-- saved from url=(0071)file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap.htm -->
<?php

require '../vendor/autoload.php';
require '../util/PSIGrabber.php';

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;

// Getting PSI data
$psi_grabber = new PSIGrabber();
$psi_data = PSIGrabber::grabData();

ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');
//remember to check user login
set_time_limit(1000);

$query = new ParseQuery("Incident");
$results = $query->find();

function getProperDateFormat($value){
  $dateFormatString = 'Y-m-d\TH:i:s.u';
  $date = date_format($value, $dateFormatString);
  $date = substr($date, 0, -3) . 'Z';
  return $date;
}

$tableHTML = '';

//show a list of incident
for ($i = 0; $i < count($results); $i++) { 
	
  $object = $results[$i];
  $id = '';
  $name = '';
  $description = '';
  $status = '';
  $location = '';
  $reporter = '';

  $name = $object->get('name');
  $id = $object->getObjectId();
  $description = $object->get('description');
  $status = $object->get('status');

  if($object->get('location')!=null){
    $location = $object->get('location');
    $location = $location->getLatitude().','.$location->getLongitude();
  }

  if($object->get('reporter')!=null){
    $object->get('reporter')->fetch();
    $reporter = $object->get('reporter')->get('username');
  }
  
  $tableHTML .= '<tr>';
  $tableHTML .= '<td>'.$id.'</td>';
  $tableHTML .= '<td>'.$name.'</td>';
  $tableHTML .= '<td>'.$status.'</td>';
  $tableHTML .= '<td>'.$description.'</td>';
  $tableHTML .= '<td>'.$location.'</td>';
  
  
  $queryAssignResource = new ParseQuery("AssignResource");
  $queryAssignResource->equalTo("incident", $object);
  $assignResourceResults = $queryAssignResource->find();

  $tableHTML .= '<td>';
  if(count($assignResourceResults)>0){
    for($j=0;$j<count($assignResourceResults);$j++){
      $assignResourceResults[$j]->get('resource')->fetch();
      $tableHTML .= $assignResourceResults[$j]->get('resource')->get('name').'&nbsp';
    }
  }
  else{
    $tableHTML .= '<button type="button" onclick="location.href = \'\assignResource.php';
	$tableHTML .= '?incident='.$id;
    $tableHTML .= '\'">assign resource</button>';
  }
  $tableHTML .= '</td>'; 

  $tableHTML .= '<td>'.$reporter.'</td>';
  $tableHTML .= '<td>'.getProperDateFormat($object->getCreatedAt()).'</td>';

  $tableHTML .= '</tr>';
}

?>
<html lang="en">
    <head>
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./template_files/ie-emulation-modes-warning.js"></script>

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
    height: 70px;
  }
  </style>

  <script src="https://maps.googleapis.com/maps/api/js"></script>
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

    function initialize() {
      var mapCanvas = document.getElementById('map_canvas');

      var mapOptions = {
        center: new google.maps.LatLng(1.3507023, 103.8500700),
        zoom: 11,
        disableZoom: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true
      }
      var map = new google.maps.Map(mapCanvas, mapOptions)

      var contentString = '<div id="content">' + '<h1>Hello</h1>' + '<div id="bodyContent">' + '<p>Hello World!</p>' + '</div>' + '<div>';

      var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 300
      });

      var TampinesLatLng = new google.maps.LatLng(1.3451044, 103.955027);

      var marker = new google.maps.Marker({
        position: TampinesLatLng,
        map: map,
        title: 'Tampines',
        width: window.innerWidth
      });

      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
      });

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

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">CMS Operator</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Dashboard</a></li>
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Settings</a></li>
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Profile</a></li>
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Overview</a></li>
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Reports</a></li>
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Analytics</a></li>
            <li><a href="file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap_files/Dashboard%20Template%20for%20Bootstrap.htm">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Singapore Map</h1>

          <div class="row placeholders">
            <div id="map_canvas"></div>
          </div>

          <h2 class="sub-header">Incident</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th>Resources</th>
                  <th>Reported by</th>
                  <th>Created at</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  echo($tableHTML);
                ?>
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
  
<div id="global-zeroclipboard-html-bridge" class="global-zeroclipboard-container" style="position: absolute; left: 0px; top: -9999px; width: 15px; height: 15px; z-index: 999999999;" title="" data-original-title="Copy to clipboard">      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="global-zeroclipboard-flash-bridge" width="100%" height="100%">         <param name="movie" value="/assets/flash/ZeroClipboard.swf?noCache=1413090888934">         <param name="allowScriptAccess" value="sameDomain">         <param name="scale" value="exactfit">         <param name="loop" value="false">         <param name="menu" value="false">         <param name="quality" value="best">         <param name="bgcolor" value="#ffffff">         <param name="wmode" value="transparent">         <param name="flashvars" value="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com">         <embed src="/assets/flash/ZeroClipboard.swf?noCache=1413090888934" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="100%" height="100%" name="global-zeroclipboard-flash-bridge" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com" scale="exactfit">                
</object>
</div>
</body>
</html>