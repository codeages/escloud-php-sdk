<?php

namespace ESCloud\SDK\Tests;

use ESCloud\SDK\Auth;
use ESCloud\SDK\HttpClient\Response;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected $accessKey = 'test_access_key';

    protected $secretKey = 'test_secret_key';

    /**
     * @var Auth
     */
    protected $auth;

    protected function setUp(): void
    {
        $this->auth = $this->createAuth();
    }

    protected function createAuth($accessKey = null, $secretKey = null)
    {
        $accessKey = $accessKey ? $accessKey : $this->accessKey;
        $secretKey = $secretKey ? $secretKey : $this->secretKey;

        return new Auth($accessKey, $secretKey);
    }

    protected function mockHttpClient($responseData, $httpStatusCode = 200)
    {
        $response = new Response(array(), json_encode($responseData), $httpStatusCode);

        $stub = $this->getMockBuilder('ESCloud\\SDK\\HttpClient\\ClientInterface')
            ->getMock();

        $stub->method('request')
            ->willReturn($response);

        return $stub;
    }
}
