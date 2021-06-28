<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit;

use IFlytek\Xfyun\Speech\QbhClient;

class QbhClientTest extends BaseClientTest
{
    public function __construct()
    {
        parent::__construct();
        $this->ability = 'qbh';
    }

    public function testSuccessfullyRequest()
    {
        $client = new QbhClient(
            $this->config['appId'],
            $this->config['apiSecret']
        );
        $result = json_decode($client->request(__DIR__ . '/../input/qbhTest.wav'), true);
        $this->assertArrayHasKey('appId', $this->config);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('song', $result['data'][0]);
        $this->assertArrayHasKey('singer', $result['data'][0]);
        $this->assertEquals(0, $result['code']);
    }
}
