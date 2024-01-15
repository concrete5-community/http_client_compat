<?php

use Concrete\Core\Support\Facade\Application;
use CHttpClient\Client;
use CHttpClient\Response;

echo 'Getting app... ';
$app = Application::getFacadeApplication();
echo "done.\n";

echo 'Creating client... ';
$client = $app->make(Client::class);
if (!$client instanceof Client) {
    throw new RuntimeException('Wrong class: ' . get_class($client));
}
echo "done.\n";

echo 'Performing request... ';
$response = $client->get('https://www.google.com');
if (!$response instanceof Response) {
    throw new RuntimeException('Wrong class: ' . get_class($response));
}
echo "done.\n";

echo 'Checking response code... ';
$code = $response->getCode();
if (!is_int($code) || $code < 1 || $code > 999) {
    throw new RuntimeException('Wrong code: ' . json_encode($code));
}
echo "done ({$code}).\n";

echo 'Checking reason phrase... ';
$reasonPhrase = $response->getReasonPhrase();
if (!is_string($reasonPhrase) || $reasonPhrase === '') {
    throw new RuntimeException('Wrong reason phrase: ' . json_encode($reasonPhrase));
}
echo "done ({$reasonPhrase}).\n";

echo 'Checking body... ';
$body = $response->getBody();
if (!is_string($body) || $body === '') {
    throw new RuntimeException('Wrong body: ' . json_encode($body));
}
echo 'done (' . strlen($body) ." bytes).\n";

return 0;
