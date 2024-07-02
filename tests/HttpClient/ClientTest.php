<?php

namespace ESCloud\SDK\Tests;

use ESCloud\SDK\HttpClient\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testRequest()
    {
        // $logger = new Logger('name');
        // $logger->pushHandler(new StreamHandler(dirname(dirname(__DIR__)).'/var/log/unittest.log'));
        $logger = null;

        $client = new Client(array(), $logger);
        $response = $client->request('GET', 'https://www.baidu.com/');
        $this->assertInstanceOf('ESCloud\\SDK\\HttpClient\\Response', $response);
    }
}
