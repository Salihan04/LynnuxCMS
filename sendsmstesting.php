<?php

# Copyright 2007 CardBoardFish
# http://www.cardboardfish.com/
# See readme.txt for terms of use.

# The examples in this file are self-contained in functions for
# convenience; uncomment the calls at the end of the file to run them.

# First, inspect the comments below.

require_once("api/SendSMS.php");

# Your username and password go here
# You MUST set these before calling any send_sms functions.
$sms_username = "soelynn0071";
$sms_password = "kuL1dZFj";

# Replace the destination number with your chosen test destination
$destination = "+6598572716";
$source =      "+6598572716";

function mydie($errstr) {
    die ("Error: " . $errstr . "\n");
}

# Plain Text SMS
# Plain SMS with User Reference and delivery receipt request
function example7_1() {
    global $destination, $source, $errstr;
    # Construct an SMS object
    $sms = new SMS();

    # Set the destination address 
    $sms->setDA($destination) or mydie($errstr);

    # Set the source address
    $sms->setSA($source) or mydie($errstr);

    # Set the user reference
    $sms->setUR("AF31C0D") or mydie($errstr);

    # Set delivery receipts to 'on'
    $sms->setDR("1") or mydie ($errstr);

    # Set the message content
    $sms->setMSG("Hello") or mydie ($errstr);

    # Send the message and inspect the responses
    $responses = send_sms_object($sms) or mydie ($errstr);
    echo "Example 7.1 Response:\n";
    foreach ($responses as $response) {
        echo "\t$response\n";
    }
}

# Flash SMS
# Plain flash SMS with User Reference and delivery receipt request
function example7_2() {
    global $source, $destination, $errstr;

    # Construct an SMS object, initialised with certain fields
    $sms = new SMS($destination, $source, "Hello", "", "0", "1", "", "MSG_1", "", "", "") or mydie ($errstr);

    # Send the message and inspect the responses
    $responses = send_sms_object($sms) or mydie ($errstr);
    echo "Example 7.2 Response:\n";
    foreach ($responses as $response) {
        echo "\t$response\n";
    }
}

# example7_1();
example7_2();
# example7_3();
# example7_4();
# example7_5();
# example7_6();
# example7_7();
# example7_8();

?>
