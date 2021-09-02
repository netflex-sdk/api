<?php

namespace Netflex\API\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $url, bool $assoc = false)
 * @method static mixed put(string $url, array $payload = [], bool $assoc = false)
 * @method static mixed post(string $url, array $payload = [], bool $assoc = false)
 * @method static mixed delete(string $url, bool $assoc = false)
 * @method static mixed setCredentials(array $options)
 * @method static \Netflex\API\Contracts\APIClient connection(string $connection)
 *
 * @see \Netflex\API\Client
 */
class API extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'api.client';
  }
}
