<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Netflex\API;

Dotenv\Dotenv::create(__DIR__)
  ->load();

API::setCredentials(
  getenv('NETFLEX_PUBLIC_KEY'),
  getenv('NETFLEX_PRIVATE_KEY')
);

$api = API::getClient();

var_dump($api->get('ping'));
die();
