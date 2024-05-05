<?php

use ESCloud\SDK\ESCloudSDK;

require dirname(__DIR__). '/vendor/autoload.php';

$env = require __DIR__. '/env.php';

$sdk = new ESCloudSDK(array(
    'access_key' => $env['access_key'],
    'secret_key' => $env['secret_key'],
));

$ai = $sdk->getAIService();

$inspected = $ai->inspectAccount();
var_dump($inspected);

$ai->disableAccount();

$inspected = $ai->inspectAccount();
var_dump($inspected);

$ai->enableAccount();

$inspected = $ai->inspectAccount();
var_dump($inspected);




$url = $ai->makeClientAppCompletionUrl('test');

var_dump($url);
