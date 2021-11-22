<?php

namespace Netflex\API;

use Netflex\API\Traits\ParsesResponse;

use Netflex\API\Contracts\APIClient;
use Netflex\API\Exceptions\MissingCredentialsException;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException as Exception;

use Psr\Http\Message\ResponseInterface;

class Client implements APIClient
{
  use ParsesResponse;

  /** @var GuzzleClient */
  protected $client;

  /** @var String */
  const BASE_URI = 'https://api.netflexapp.com/v1/';

  /**
   * @param string $publicKey
   * @param string $privateKey
   * @param array $options
   */
  public function __construct(array $options = [])
  {
    $options['base_uri'] = $options['base_uri'] ?? static::BASE_URI;
    $options['auth'] = $options['auth'] ?? null;

    if (!$options['auth']) {
      throw new MissingCredentialsException;
    }

    $this->client = new GuzzleClient($options);
  }

  /**
   * Returns the raw internal Guzzle instance
   *
   * @return GuzzleClient
   */
  public function getGuzzleInstance()
  {
    return $this->client;
  }

  protected function buildPayload($payload)
  {
    return ['json' => $payload];
  }

  /**
   * @param string $url
   * @return ResponseInterface
   */
  public function getRaw($url)
  {
    return $this->client->get($url);
  }

  /**
   * @param string $url
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function get($url, $assoc = false)
  {
    return $this->parseResponse($this->getRaw($url), $assoc);
  }

  /**
   * @param string $url
   * @param array|null $payload = []
   * @return ResponseInterface
   */
  public function putRaw($url, $payload)
  {
    return $this->client->put($url, $this->buildPayload($payload));
  }

  /**
   * @param string $url
   * @param array|null $payload = []
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function put($url, $payload = [], $assoc = false)
  {
    return $this->parseResponse($this->putRaw($url, $payload), $assoc);
  }

  /**
   * @param string $url
   * @param array|null $payload = []
   * @return ResponseInterface
   */
  public function postRaw($url, $payload)
  {
    return $this->client->post($url, $this->buildPayload($payload));
  }

  /**
   * @param string $url
   * @param array|null $payload = []
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function post($url, $payload = [], $assoc = false)
  {
    return $this->parseResponse($this->postRaw($url, $payload), $assoc);
  }

  /**
   * @param string $url
   * @return ResponseInterface
   */
  public function deleteRaw($url)
  {
    return $this->client->delete($url);
  }

  /**
   * @param string $url
   * @return mixed
   * @throws Exception
   */
  public function delete($url, $assoc = false)
  {
    return $this->parseResponse($this->deleteRaw($url), $assoc);
  }
}
