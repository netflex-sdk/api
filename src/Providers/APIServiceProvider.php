<?php

namespace Netflex\API\Providers;

use Netflex\API\Client;
use Netflex\API\Contracts\APIClient;
use Netflex\API\Exceptions\MissingCredentialsException;

use Illuminate\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->alias('api.client', Client::class);
    $this->app->alias('api.client', APIClient::class);

    $this->app->singleton('api.client', function () {
      $publicKey = $this->app['config']['api.publicKey'] ?? null;
      $privateKey = $this->app['config']['api.privateKey'] ?? null;
      $baseUri = $this->app['config']['api.baseUri'] ?? null;

      if ($publicKey && $privateKey) {
        $options = [
          'base_uri' => $baseUri,
          'auth' => [
            $publicKey,
            $privateKey,
          ],
        ];

        return new Client($options);
      }

      throw new MissingCredentialsException();
    });
  }
}
