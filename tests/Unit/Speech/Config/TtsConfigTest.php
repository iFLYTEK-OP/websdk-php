<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech\Config;

use IFlytek\Xfyun\Speech\Config\TtsConfig;
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use IFlytek\Xfyun\Core\Traits\ArrayTrait;
use PHPUnit\Framework\TestCase;

class TtsConfigTest extends TestCase
{
    use JsonTrait;
    use ArrayTrait;

    public function testConfigSuccessfullyToJson()
    {
        $config = new TtsConfig();
        $config = $this->jsonDecode($config->toJson(), true);
        $this->assertEquals('lame', $config['aue']);
        $this->assertEquals(1, $config['sfl']);
        $this->assertEquals('xiaoyan', $config['vcn']);
        $this->assertEquals(50, $config['speed']);
        $this->assertEquals(50, $config['volume']);
        $this->assertEquals(50, $config['pitch']);
        $this->assertEquals(0, $config['bgs']);
        $this->assertEquals('UTF8', $config['tte']);
        $this->assertEquals('2', $config['reg']);
        $this->assertEquals('0', $config['rdn']);
    }
}
