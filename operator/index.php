<?php

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
	echo('<li>'.$object->get('location')->getLatitude().'</li>');

	$object->get('reporter')->fetch();

	echo('<li>'.$object->get('reporter')->get('username').'</li>');
	echo('<li>'.getProperDateFormat($object->getCreatedAt()).'</li>');
	echo('</ul>');

	echo('</li>');
}
?>

</ol>
<!-- end of a list of incident -->

<?php

?>