<!DOCTYPE html>
<!-- saved from url=(0071)file:///C:/wamp/www/operator/Dashboard%20Template%20for%20Bootstrap.htm -->
<?php

require '../vendor/autoload.php';

use Parse\ParseClient;

ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');


use Parse\ParseObject;
use Parse\ParseQuery;

//remember to check user login

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
    for($i=0;$i<count($assignResourceResults);$i++){
      $assignResourceResults[$i]->get('resource')->fetch();
      $tableHTML .= $assignResourceResults[$i]->get('resource')->get('name').'&nbsp';
    }
  }
  else{
    $tableHTML .= '<button type="button" onclick="location.href = \'\assignResource.php\'">assign resource</button>';
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
  </style>

  <script src="https://maps.googleapis.com/maps/api/js"></script>
  <script>
    function initialize() {
      var mapCanvas = document.getElementById('map_canvas');
      var mapOptions = {
        center: new google.maps.LatLng(1.3507023, 103.8500700),
        zoom: 11,
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
  

<div id="global-zeroclipboard-html-bridge" class="global-zeroclipboard-container" style="position: absolute; left: 0px; top: -9999px; width: 15px; height: 15px; z-index: 999999999;" title="" data-original-title="Copy to clipboard">      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="global-zeroclipboard-flash-bridge" width="100%" height="100%">         <param name="movie" value="/assets/flash/ZeroClipboard.swf?noCache=1413090888934">         <param name="allowScriptAccess" value="sameDomain">         <param name="scale" value="exactfit">         <param name="loop" value="false">         <param name="menu" value="false">         <param name="quality" value="best">         <param name="bgcolor" value="#ffffff">         <param name="wmode" value="transparent">         <param name="flashvars" value="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com">         <embed src="/assets/flash/ZeroClipboard.swf?noCache=1413090888934" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="100%" height="100%" name="global-zeroclipboard-flash-bridge" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="trustedOrigins=getbootstrap.com%2C%2F%2Fgetbootstrap.com%2Chttp%3A%2F%2Fgetbootstrap.com" scale="exactfit">                
</object>
</div>
</body>
</html>