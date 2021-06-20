<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use IFlytek\Xfyun\Speech\IgrClient;

class IgrClientTest extends BaseClientTest
{
    public function __construct()
    {
        parent::__construct();
        $this->ability = 'common';
    }

    public function testSuccessfullyRequest()
    {
        $client = new IgrClient(
            $this->config['appId'],
            $this->config['apiKey'],
            $this->config['apiSecret']
        );
        $result = $client->request(__DIR__ . '/../../input/igr_pcm_16k.pcm');
        $this->assertArrayHasKey('appId', $this->config);
        $this->assertArrayHasKey('result', $result);
        $this->assertArrayHasKey('age', $result['result']);
        $this->assertArrayHasKey('age_type', $result['result']['age']);
        $this->assertEquals(2, $result['status']);
    }
}
