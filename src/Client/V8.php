<?php

namespace CHttpClient\Client;

use CHttpClient\Client;
use CHttpClient\Response;
use Concrete\Core\Http\Client\Client as CoreClient;
use RuntimeException;
use Zend\Http\Request;

final class V8 implements Client
{
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
     * @see \CHttpClient\Client::delete()
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
        $zendRequest = new Request();
        $zendRequest
            ->setMethod($method)
            ->setUri($url)
        ;
        if (isset($options['body'])) {
            $zendRequest->setContent($options['body']);
        }
        $zendHeaders = $zendRequest->getHeaders();
        foreach ($headers as $name => $value) {
            $zendHeaders->addHeaderLine($name, $value);
        }
        $zendResponse = $this->coreClient->send($zendRequest);
        $result = new Response(
            $zendResponse->getStatusCode(),
            $zendResponse->getReasonPhrase(),
            $zendResponse->getHeaders()->toArray(),
            $zendResponse->getBody()
        );

        return $result;
    }
}
