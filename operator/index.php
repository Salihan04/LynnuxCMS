<!DOCTYPE html>
<html>

<head>
	<style>
	#map_canvas {
		width: 700px;
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
        output += "<p id='info'><img src=http://l.yimg.com/a/i/us/we/52/" + icon + ".gif height='30' width='30'><br/>H:" + high + "&degC"+"<br/> L:" + low + "&degC</p>";
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
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true
		}
		var map = new google.maps.Map(mapCanvas, mapOptions)

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

		google.maps.event.addListener(northMarker, 'click', function() {
			northInfoWindow.open(map, northMarker);
		});

		google.maps.event.addListener(eastMarker, 'click', function() {
			eastInfoWindow.open(map, eastMarker);
		});

		google.maps.event.addListener(southMarker, 'click', function() {
			southInfoWindow.open(map, southMarker);
		});

		google.maps.event.addListener(westMarker, 'click', function() {
			westInfoWindow.open(map, westMarker);
		});

		google.maps.event.addListener(centralMarker, 'click', function() {
			centralInfoWindow.open(map, centralMarker);
		});

		return map;
	}

	// google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>

<body onload="initialize()">

	<h1>Singapore Map</h1>
	<div id="map_canvas"></div>
	<div id="North"></div>
    <div id="West"></div>
    <div id="South"></div>
    <div id="East"></div>
    <div id="Central"></div>
	<br/>

	<script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D1062668%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D1062494%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D24703053%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D1062460%0A&format=json&diagnostics=true&callback=weather'></script>
    <script src='https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D24703032%0A&format=json&diagnostics=true&callback=weather'></script>
	<!-- <h1>Map 2</h1> -->
	<!-- <iframe width="700" height="500" frameborder="0" style="border:0" maptype="satellite" src="https://www.google.com/maps/embed/v1/view?&key=AIzaSyCbwMWSHWmxSvROYPQUUw9d9Ogop2C4HsU&center=1.3507023,103.8500700&zoom=11"></iframe> -->

	.<?php

	require '../vendor/autoload.php';

	use Parse\ParseClient;

	ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');


	use Parse\ParseObject;
	use Parse\ParseQuery;

// $testObject = ParseObject::create("TestObject");
// $testObject->set("foo", "bar");
// $testObject->save();

//remember to check user login

	$query = new ParseQuery("Incident");
//$query->equalTo("name", "Hungry Spree");
	$results = $query->find();
	echo("Successfully retrieved " . count($results) . " incident.");

	?>

	<!-- start of a list of incident -->
	<p>Incident List</p>
	<ol>

		<?php
		function getProperDateFormat($value){
			$dateFormatString = 'Y-m-d\TH:i:s.u';
			$date = date_format($value, $dateFormatString);
			$date = substr($date, 0, -3) . 'Z';
			return $date;
		}
//show a list of incident
		for ($i = 0; $i < count($results); $i++) { 
			$object = $results[$i];
			echo('<li>');
			echo($object->getObjectId() . ' - ' . $object->get('name'));

			echo('<ul>');
			echo('<li>'.$object->get('description').'</li>');
			echo('<li>'.$object->get('status').'</li>');
			echo('<li>'.$object->get('location')->getLatitude().','.$object->get('location')->getLongitude().'</li>');

			$object->get('reporter')->fetch();

			echo('<li>'.$object->get('reporter')->get('username').'</li>');
			echo('<li>'.getProperDateFormat($object->getCreatedAt()).'</li>');

			$queryAssignResource = new ParseQuery("AssignResource");
			$queryAssignResource->equalTo("incident", $object);
			$assignResourceResults = $queryAssignResource->find();


			if(count($assignResourceResults)>0){
				echo('<li>'.'Resources:'.'</li>');

				echo('<ul>');
				for($i=0;$i<count($assignResourceResults);$i++){
					$assignResourceResults[$i]->get('resource')->fetch();
					echo('<li>'.$assignResourceResults[$i]->get('resource')->get('name').'</li>');
				}
				echo('</ul>');
			}
			else{
				?>
				<li>no resource yet</li>
				<button type='button' onclick="location.href = '\assignResource.php'">assign resource</button>
				<?php
			}



			echo('</ul>');

			echo('</li>');
		}
		?>

	</ol>
	<!-- end of a list of incident -->

	<?php

	?>

</body>

</html>