<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class BaseClientTest extends TestCase
{
    protected $ability = 'common';

    protected $config;

    public function setUp()
    {
        $credentials = [
            'common' => [
                'appId' => getenv('PHPSDK_SPEECH_TTS_APPID'),
                'apiKey' => getenv('PHPSDK_SPEECH_TTS_APIKEY'),
                'apiSecret' => getenv('PHPSDK_SPEECH_TTS_APISECRET')
            ],
            'lfasr' => [
                'appId' => getenv('PHPSDK_SPEECH_LFASR_APPID'),
                'secretKey' => getenv('PHPSDK_SPEECH_LFASR_SECRETKEY'),
                'taskId' => getenv('PHPSDK_SPEECH_LFASR_TASKID')
            ],
            'qbh' => [
                'appId' => getenv('PHPSDK_SPEECH_TTS_APPID'),
                'apiSecret' => getenv('PHPSDK_CORE_QBH_SECRETKEY')
            ]
        ];
        $this->config = $credentials[$this->ability];
    }

    public function testSuccessGetEnv()
    {
        $this->assertNotNull($this->config['appId']);
    }
}
