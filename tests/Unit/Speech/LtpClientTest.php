<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use IFlytek\Xfyun\Speech\Constants\LtpConstants;
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use IFlytek\Xfyun\Speech\LtpClient;

class LtpClientTest extends BaseClientTest
{
    use JsonTrait;

    /** @var LtpClient */
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->ability = 'common';
    }

    public function setUp()
    {
        parent::setUp();
        $this->client = new LtpClient($this->config['appId'], $this->config['apiKey']);
    }

    public function testSuccessfullyRequest()
    {
        $func = LtpConstants::FUNC[array_rand(LtpConstants::FUNC)];

        $this->assertInstanceOf(LtpClient::class, $this->client);
        $response = $this->client->request($func, '他叫汤姆去拿外衣。');
        $this->assertEquals(200, $response->getStatusCode());
        $result = $this->jsonDecode($response->getBody()->getContents(), true);
        $this->assertEquals(0, $result['code']);
    }
}
