<?php

require 'vendor/autoload.php';
 
use Parse\ParseClient;
 
ParseClient::initialize('qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW', '9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL', 'MjYJYsSjr5wZVntUFxDvv0VpXGqhPOT8YFpULNB2');


use Parse\ParseObject;
use Parse\ParseQuery;
 
// $testObject = ParseObject::create("TestObject");
// $testObject->set("foo", "bar");
// $testObject->save();

$query = new ParseQuery("Incident");
//$query->equalTo("name", "Hungry Spree");
$results = $query->find();
echo("Successfully retrieved " . count($results) . " incident.");
// Do something with the returned ParseObject values
for ($i = 0; $i < count($results); $i++) { 
  $object = $results[$i];
  echo($object->getObjectId() . ' - ' . $object->get('name'));
}

?>