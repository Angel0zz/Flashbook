<?php
require_once './vendor/autoload.php';

// Initialize configuration
$clientID ='897132130369-vric1b8sofh2irdvgc9e078eh768v5sf.apps.googleusercontent.com';
$clientSecret ='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';
$redirectUri = 'http://localhost/flashbook/';

// Create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope('email');
$client->addScope('profile');


$hostname = "localhost";
$dbusername = "root";
$dbpassword = "";
$database ="flashbook";

$con = mysqli_connect($hostname, $dbusername , $dbpassword , $database);
 ?>