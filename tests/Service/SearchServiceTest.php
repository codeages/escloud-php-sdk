<?php

namespace ESCloud\SDK\Tests\Service;

use ESCloud\SDK\Auth;
use ESCloud\SDK\Service\SearchService;
use ESCloud\SDK\Tests\BaseTestCase;

class SearchServiceTest extends BaseTestCase
{
    protected function createAuth($accessKey = null, $secretKey = null)
    {
        $accessKey = $accessKey ? $accessKey : $this->accessKey;
        $secretKey = $secretKey ? $secretKey : $this->secretKey;

        return new Auth($accessKey, $secretKey, true);
    }

    public function testCreateAccount()
    {
        $mock = array('success' => true);
        $httpClient = $this->mockHttpClient($mock);
        $service = new SearchService($this->auth, array(), null, $httpClient);
        $result = $service->createAccount();

        $this->assertTrue($result['success']);
    }

    public function testReport()
    {
        $mock = array('success' => true);
        $httpClient = $this->mockHttpClient($mock);
        $service = new SearchService($this->auth, array(), null, $httpClient);
        $result = $service->report('course', array('resources' => json_encode(array(
                array('id' => 1, 'title' => 'course1', 'lessons' => array(array('title' => 'lesson1'), array('title' => 'lesson2'))),
                array('id' => 2, 'title' => 'course2', 'lessons' => array(array('title' => 'lesson3'), array('title' => 'lesson4'))),
            ))));

        $this->assertTrue($result['success']);
    }

    public function testDeleteData()
    {
        $mock = array('success' => true);
        $httpClient = $this->mockHttpClient($mock);
        $service = new SearchService($this->auth, array(), null, $httpClient);
        $result = $service->deleteData('course', 1);

        $this->assertTrue($result['success']);
    }

    public function testRestartReport()
    {
        $mock = array('success' => true);
        $httpClient = $this->mockHttpClient($mock);
        $service = new SearchService($this->auth, array(), null, $httpClient);
        $result = $service->restartReport(array('categories' => json_encode(array('course', 'classroom'))));

        $this->assertTrue($result['success']);
    }

    public function testRestartReportFinish()
    {
        $mock = array('success' => true);
        $httpClient = $this->mockHttpClient($mock);
        $service = new SearchService($this->auth, array(), null, $httpClient);
        $result = $service->restartReportFinish(array('categories' => json_encode(array('course', 'classroom'))));

        $this->assertTrue($result['success']);
    }
}
