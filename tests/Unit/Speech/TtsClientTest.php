<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use IFlytek\Xfyun\Speech\TtsClient;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TtsClientTest extends BaseClientTest
{
    public function __construct()
    {
        parent::__construct();
        $this->ability = 'common';
    }

    public function testSuccessfullyRequest()
    {

        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler(__DIR__.'/unit.test.log', Logger::DEBUG));
        $client = new TtsClient(
            $this->config['appId'],
            $this->config['apiKey'],
            $this->config['apiSecret'],
            [],
            $logger
        );
        $result = $client->request('爱我中华');
        $this->assertArrayHasKey('appId', $this->config);
        $this->assertInstanceOf(TtsClient::class, $client);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('58173aacf1dabcb66fcd3fb7c54c0d68', md5($result->getBody()));
    }
}
