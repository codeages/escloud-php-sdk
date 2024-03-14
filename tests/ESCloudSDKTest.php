<?php

namespace ESCloud\SDK\Tests\Service;

use ESCloud\SDK\ESCloudSDK;
use ESCloud\SDK\Tests\BaseTestCase;

class ESCloudSDKTest extends BaseTestCase
{
    public function testGetService()
    {
        $sdk = new ESCloudSDK(array(
            'access_key' => $this->accessKey,
            'secret_key' => $this->secretKey,
            'service' => array(
                'sms' => array(
                    'host' => 'sms-service.test.qiqiuyun.net', // 每个服务，都有自己的必需的配置项，如需调用则必需配置该服务的配置项
                ),
            ),
        ));

        $this->assertInstanceOf('ESCloud\\SDK\\Service\\AiService', $sdk->getAiService());
        $this->assertInstanceOf('ESCloud\\SDK\\Service\\SmsService', $sdk->getSmsService());
        $this->assertInstanceOf('ESCloud\\SDK\\Service\\PlayService', $sdk->getPlayService());
        $this->assertInstanceOf('ESCloud\\SDK\\Service\\DrpService', $sdk->getDrpService());
    }
}
