<?php

namespace Netflex\Contracts;

interface ApiClient
{
  /**
   * @param string $url
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function get($url, $assoc = false);

  /**
   * @param string $url
   * @param array $payload = []
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function put($url, $payload = [], $assoc = false);

  /**
   * @param string $url
   * @param array $payload = []
   * @param boolean $assoc = false
   * @return mixed
   * @throws Exception
   */
  public function post($url, $payload = [], $assoc = false);

  /**
   * @param string $url
   * @return mixed
   * @throws Exception
   */
  public function delete($url, $assoc = false);
}
