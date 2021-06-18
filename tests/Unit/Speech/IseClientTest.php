<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use IFlytek\Xfyun\Speech\IseClient;

class IseClientTest extends BaseClientTest
{
    public function __construct()
    {
        parent::__construct();
        $this->ability = 'common';
    }

    public function testSuccessfullyRequest()
    {
        $client = new IseClient(
            $this->config['appId'],
            $this->config['apiKey'],
            $this->config['apiSecret'],
            [
                'aue' => 'lame'
            ]
        );
        $result = $client->request(__DIR__ . '/../../input/iseTest.mp3', '欢迎使用科大讯飞语音能力，让我们用人工智能改变世界');
        $this->assertArrayHasKey('appId', $this->config);
        $this->assertEquals('2104d20080a4f9087780ee40b4e6155c', md5($result));
    }
}
