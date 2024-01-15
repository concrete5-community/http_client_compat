<?php

namespace CHttpClient;

interface Client
{
    /**
     * @param string $url
     *
     * @return \CHttpClient\Response
     */
    public function get($url, array $headers = []);

    /**
     * @param string $url
     *
     * @return \CHttpClient\Response
     */
    public function delete($url, array $headers = []);

    /**
     * @param string $url
     * @param string $body
     *
     * @return \CHttpClient\Response
     */
    public function post($url, $body, array $headers = []);

    /**
     * @param string $url
     * @param string $body
     *
     * @return \CHttpClient\Response
     */
    public function put($url, $body, array $headers = []);
}
