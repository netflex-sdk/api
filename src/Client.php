<?php

namespace Netflex\API;

use Netflex\API\Contracts\APIClient;
use Netflex\API\Exceptions\MissingCredentialsException;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException as Exception;

use Psr\Http\Message\ResponseInterface;

class Client implements APIClient
{
  /** @var Client */
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
   * @param ResponseInterface $response
   * @return mixed
   */
  private function parseResponse(ResponseInterface $response, $assoc = false)
  {
    $body = $response->getBody();

    $contentType = strtolower($response->getHeaderLine('Content-Type'));

    if (strpos($contentType, 'json') !== false) {
      $jsonBody = json_decode($body, $assoc);

      if (json_last_error() === JSON_ERROR_NONE) {
        return $jsonBody;
      }
    }

    if (strpos($contentType, 'text') !== false) {
      return $body->getContents();
    }

    return null;
  }

  /**
   * @param string $url
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function get($url, $assoc = false)
  {
    return $this->parseResponse(
      $this->client->get($url),
      $assoc
    );
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

  /**
   * @param string $url
   * @param array $payload = []
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function put($url, $payload = [], $assoc = false)
  {
    return $this->parseResponse(
      $this->client->put($url, ['json' => $payload]),
      $assoc
    );
  }

  /**
   * @param string $url
   * @param array $payload = []
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function post($url, $payload = [], $assoc = false)
  {
    return $this->parseResponse(
      $this->client->post($url, ['json' => $payload]),
      $assoc
    );
  }

  /**
   * @param string $url
   * @return mixed
   * @throws Exception
   */
  public function delete($url, $assoc = false)
  {
    return $this->parseResponse(
      $this->client->delete($url),
      $assoc
    );
  }
}
