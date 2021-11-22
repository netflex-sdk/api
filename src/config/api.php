<?php

return [

  /*
   |--------------------------------------------------------------------------
   | Credentials
   |--------------------------------------------------------------------------
   |
   | Your application's API credentials for communicating with the
   | Netflex Content API.
   |
   */

  'publicKey' => env('NETFLEX_PUBLIC_KEY', null),
  'privateKey' => env('NETFLEX_PRIVATE_KEY', null),

  /*
   |--------------------------------------------------------------------------
   | Base URI
   |--------------------------------------------------------------------------
   |
   | This allows you to override the base URI used for communicating with
   | the API. Thus can be used for testing against the development-
   | API etc.
   |
   */

   'baseUri' => env('NETFLEX_URI', 'https://api.netflexapp.com/v1/'),
];
