<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

$uri = 'https://keepcontact_api_url/';
$login = 'login';
$password = 'password';

try {
    $client = new \KeepContact\KeepContactClient($uri, $login, $password); 

    $client->sendSms(
        '0601020304', 
        "test", 
        "INFOSMS"
    );
} catch (Exception $e) {
    echo 'Une erreur est survenue : ' . $e->getMessage() . ' (code : ' . $e->getCode() . ')';
}
