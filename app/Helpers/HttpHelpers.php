<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Helper methods using the Guzzle PHP Http client.
 *
 * To use guzzle you need to have two instances of php artisan serve running (as they are single-threaded).
 * For example :8000 is used for the API and the other instance for the frontend testing.
 * See: https://stackoverflow.com/questions/48841018/guzzle-cannot-make-get-request-to-the-localhost-port-80-8000-8080-etc/57573002#57573002
 */
class HttpHelpers {
  /**
   * Guzzle http client
   *
   * @var \GuzzleHttp\Client
   */
  private static $client = null;

  public static function get($path) {
    $client = self::getClient();

    $response = $client->request('GET', $path);

    return $response;
  }

  public static function postJson($path, $data) {
    $client = self::getClient();

    $json = json_encode($data);
    $response = $client->request('POST', $path, ['json' => $json]);

    return $response;
  }

  public static function patchJson($path, $data) {
    $client = self::getClient();

    $json = json_encode($data);

    $response = $client->request('PATCH', $path, ['json' => $json]);

    return $response;
  }

  public static function bodyToJson(ResponseInterface $response) {
    $contents = $response->getBody()->getContents();

    return json_decode($contents);
  }

  public static function getClient() {
    if (self::$client == null) {
      self::$client = new Client([
        'base_uri' => self::getBaseUri(),
        'headers' => [
          'Accept' => 'application/json'
        ]
      ]);
    }

    return self::$client;
  }

  public static function getBaseUri() {
    $addr = env(
      'API_HOST',
      (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : 'localhost'
    );

    $port = env(
      'API_PORT',
      (isset($_SERVER['SERVER_PORT'])) ? $_SERVER['SERVER_PORT'] : '8000'
    );

    return "http://$addr:$port";
  }
}