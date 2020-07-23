<?php 
// https://cmder.net/
// https://psysh.org/

// https://www.tutorialrepublic.com/php-tutorial/
// https://www.php.net/manual/pt_BR/index.php
// https://getcomposer.org/doc/01-basic-usage.md

// composer require guzzlehttp/guzzle
// composer require vlucas/phpdotenv

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use GuzzleHttp\Client;

// print_r($argv);

$mode = 'current';
$ndays = 0;

if( $argc < 2) {
	die("Use: app <location> [<language>] \n");
}
elseif( $argc == 2 ) {
	$location = $argv[1];
	$language = 'pt_br';
}
else {
	$location = $argv[1];
	$language = strtolower($argv[2]);
	if(!array_key_exists($language, $messages) ) {
		die("Idioma desconhecido!\n");
	}
}


// https://github.com/vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// https://weatherstack.com/quickstart
// https://weatherstack.com/documentation
/*
http://api.weatherstack.com/current
  ? access_key = YOUR_ACCESS_KEY
    & query = New York
*/

// Base URI is used with relative requests
    $client = new Client( ['base_uri' => $_ENV['SERVER_URL']] );

    $mode  = 'current';
    $query = ['access_key' => $_ENV['ACCESS_KEY'], 'query' => $location ];

    $response = $client->request('GET', $mode, ['query' => $query ] );

    if($response->getStatusCode() == 200 ) {
    	$result = json_decode( $response->getBody(), TRUE );

    	if( array_key_exists('error', $result) ) {
    		if( $result['error']['type'] == 'request_failed' ) {
    			echo sprintf("\n%s (code=%d)\n", $result['error']['info'], $result['error']['code'] );
    			exit(-1);
    		}else {
    			print_r($result);
    			exit(-1);
    		}
    	}
    }
    echo sprintf($messages[$language]['name'], $result['location']['name']);
    echo sprintf($messages[$language]['country'], $result['location']['country']);
    echo sprintf($messages[$language]['region'], $result['location']['region']);
    echo sprintf($messages[$language]['lat'], $result['location']['lat']);
    echo sprintf($messages[$language]['lon'], $result['location']['lon']);
    echo sprintf($messages[$language]['timezone_id'], $result['location']['timezone_id']);
    echo sprintf($messages[$language]['localtime'], $result['location']['localtime']);
    echo sprintf($messages[$language]['temperature'], $result['current']['temperature']);
    echo sprintf($messages[$language]['wind_speed'], $result['current']['wind_speed']);