<?php

namespace Netflex;

use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class API
{
  /** @var static */
  private static $instance;

  /** @var array|null */
  private static $credentials;

  /** @var Client */
  protected $client;

  /** @var String */
  protected $baseURI = 'https://api.netflexapp.com/v1/';

  /**
   * @param string $publicKey
   * @param string $privateKey
   * @param array $options
   */
  private function __construct(string $publicKey, string $privateKey, array $options = [])
  {
    $options['base_uri'] = $this->baseURI;
    $options['auth'] = [ $publicKey, $privateKey ];

    $this->client = new Client($options);
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

  /**
   * @param string $publicKey
   * @param string $privateKey
   * @return void
   */
  public static function setCredentials(string $publicKey, string $privateKey)
  {
    static::$credentials = [$publicKey, $privateKey];
  }

  /**
   * @param string $publicKey
   * @param string $privateKey
   * @param array $options = []
   * @return static
   */
  public static function factory (string $publicKey, string $privateKey, $options = []) {
    return new static ($publicKey, $privateKey, $options);
  }

  /**
   * Override the shared client instance. Useful for doing mocks in testing.
   *
   * @param stdClass $client
   * @return void
   */
  public static function setClient ($client) {
    static::$instance = $client;
  }

  /**
   * @throws Exception
   * @return static
   */
  public static function getClient()
  {
    if (!static::$instance && static::$credentials) {
      list($publicKey, $privateKey) = static::$credentials;
      static::$instance = static::factory($publicKey, $privateKey);
    }

    if (static::$instance) {
      return static::$instance;
    }

    throw new Exception('Missing credentials');
  }
}
