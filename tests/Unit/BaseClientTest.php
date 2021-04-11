<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class BaseClientTest extends TestCase
{
    protected $ability = 'tts';

    protected $config;

    public function setUp()
    {
        $credentials = [
            'tts' => [
                'appId' => getenv('PHPSDK_SPEECH_TTS_APPID'),
                'apiKey' => getenv('PHPSDK_SPEECH_TTS_APIKEY'),
                'apiSecret' => getenv('PHPSDK_SPEECH_TTS_APISECRET')
            ],
            'lfasr' => [
                'appId' => getenv('PHPSDK_SPEECH_LFASR_APPID'),
                'secretKey' => getenv('PHPSDK_SPEECH_LFASR_SECRETKEY'),
                'taskId' => getenv('PHPSDK_SPEECH_LFASR_TASKID')
            ]
        ];
        $this->config = $credentials[$this->ability];
    }

    public function testSuccessGetEnv() {
        $this->assertNotNull($this->config['appId']);
    }
}
