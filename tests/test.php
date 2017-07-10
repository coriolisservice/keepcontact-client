<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

$uri = 'https://www.coriolis-web.fr/keep-contact/api/';
$login = 'direxi';
$password = '';

try {
    $client = new \KeepContact\KeepContactClient($uri, $login, $password); 

    $client->sendSms(
        '0683171556', 
        "test", 
        "DIREXI"
    );
} catch (Exception $e) {
    echo 'Une erreur est survenue : ' . $e->getMessage() . ' (code : ' . $e->getCode() . ')';
}
