<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit;

use IFlytek\Xfyun\Speech\IseClient;

class IseClientTest extends BaseClientTest
{
    public function __construct()
    {
        parent::__construct();
        $this->ability = 'ise';
    }

    public function testSuccessfullyRequest()
    {
        $client = new IseClient(
            $this->config['appId'],
            $this->config['apiKey'],
            $this->config['apiSecret'],
            []
        );
        $result = $client->request(__DIR__ . '/../input/1.wav', '爱我中华');
        $this->assertArrayHasKey('appId', $this->config);
    }
}
