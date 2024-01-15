<?php

namespace CHttpClient;

use RuntimeException;

class Response
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $reasonPhrase;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @param int $code
     * @param string $reasonPhrase
     * @param string $body
     */
    public function __construct($code, $reasonPhrase, array $headers, $body)
    {
        $this->code = $code;
        $this->reasonPhrase = $reasonPhrase;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getFirstHeaderValue($key)
    {
        $key = strtolower($key);
        foreach ($this->headers as $k => $v) {
            if (strtolower($k) !== $key) {
                continue;
            }

            return (string) (is_array($v) ? array_shift($v) : $v);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param bool $associative
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public function getBodyJson($associative = true)
    {
        if ($this->body === 'null') {
            return null;
        }
        set_error_handler(static function () {}, -1);
        try {
            $json = json_decode($this->body, (bool) $associative);
        } finally {
            restore_error_handler();
        }
        if ($json === null) {
            throw new RuntimeException(t('The response is not in JSON format'));
        }
        $this->decodedJson = $json;
        
        return $this->decodedJson;
    }

    /**
     * @return bool
     */
    public function isOK()
    {
        return $this->code >= 200 && $this->code < 300;
    }
}
