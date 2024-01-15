<?php

namespace CHttpClient\Client;

use Concrete\Core\Http\Client\Client as CoreClient;
use RuntimeException;
use CHttpClient\Client;
use CHttpClient\Response;

final class V9 implements Client
{
    /**
     * @var \Concrete\Core\Http\Client\Client
     */
    private $coreClient;

    public function __construct(CoreClient $coreClient)
    {
        $this->coreClient = $coreClient;
    }

    /**
     * {@inheritdoc}
     *
     * @see \CHttpClient\Client::get()
     */
    public function get($url, array $headers = [])
    {
        return $this->invokeMethod('get', $url, $headers);
    }

    /**
     * {@inheritdoc}
     *
     * @see \CHttpClient\Client::get()
     */
    public function delete($url, array $headers = [])
    {
        return $this->invokeMethod('delete', $url, $headers);
    }

    /**
     * {@inheritdoc}
     *
     * @see \CHttpClient\Client::post()
     */
    public function post($url, $body, array $headers = [])
    {
        return $this->invokeMethod('post', $url, $headers, ['body' => $body]);
    }

    /**
     * {@inheritdoc}
     *
     * @see \CHttpClient\Client::put()
     */
    public function put($url, $body, array $headers = [])
    {
        return $this->invokeMethod('put', $url, $headers, ['body' => $body]);
    }

    /**
     * @throws \RuntimeException
     */
    private function invokeMethod($method, $url, array $headers = [], array $options = [])
    {
        $guzzleResponse = $this->coreClient->request($method, $url, ['http_errors' => false, 'headers' => $headers] + $options);
        $result = new Response(
            $guzzleResponse->getStatusCode(),
            $guzzleResponse->getReasonPhrase(),
            $guzzleResponse->getHeaders(),
            $guzzleResponse->getBody()->getContents()
        );

        return $result;
    }
}
