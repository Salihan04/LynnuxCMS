<!DOCTYPE html>
<html>

<head>
	<style>
	#map_canvas {
		width: 700px;
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
			title: 'Tampines'
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
	}

	google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>

<body>

	<h1>Singapore Map</h1>
	<div id="map_canvas"></div>
	<br/>
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