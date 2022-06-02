<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use IFlytek\Xfyun\Speech\TcClient;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TcClientTest extends BaseClientTest
{
    public function __construct()
    {
        parent::__construct();
        $this->ability = 'common';
    }

    public function testSuccessfullyRequest()
    {
        $client = new TcClient(
            $this->config['appId'],
            $this->config['apiKey'],
            $this->config['apiSecret']
        );

        $result = $client->request('历史上有很多注明的人物，其中唐太宗李世民就是一位。');
        $data =  json_decode($result->getBody()->getContents(), true);
        $content = $data['payload']['result']['text'];
        $this->assertArrayHasKey('appId', $this->config);
        $this->assertInstanceOf(TcClient::class, $client);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('b513941b0424175564a1275f0f543b3b', md5($content));
    }

    public function testSuccessfullyListUploadAndRequest() {
        $client = new TcClient(
            $this->config['appId'],
            $this->config['apiKey'],
            $this->config['apiSecret'],
            '1001',
            '2002'
        );

        $this->assertTrue($client->listUpload("注明", "世民 市民,人物 任务"));

        $result = $client->request('历史上有很多注明的人物，其中唐太宗李世民就是一位。');
        $data =  json_decode($result->getBody()->getContents(), true);
        $content = $data['payload']['result']['text'];
        $this->assertArrayHasKey('appId', $this->config);
        $this->assertInstanceOf(TcClient::class, $client);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('2db635360fb910c74da8acbb02250062', md5($content));
    }
}
