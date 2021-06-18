<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech\Helper;

use IFlytek\Xfyun\Speech\Helper\SliceIdGenerater;
use PHPUnit\Framework\TestCase;

class SliceIdGeneraterTest extends TestCase
{
    public function testSliceIdSuccessfullyGenerate()
    {
        $generater = new SliceIdGenerater();
        $this->assertEquals('aaaaaaaaaa', $generater->getId());
        $this->assertEquals('aaaaaaaaab', $generater->getId());
        $this->assertEquals('aaaaaaaaac', $generater->getId());
        for ($i = 0; $i < 23; $i++) {
            $generater->getId();
        }
        $this->assertEquals('aaaaaaaaba', $generater->getId());
        for ($i = 0; $i < 25; $i++) {
            $generater->getId();
        }
        $this->assertEquals('aaaaaaaaca', $generater->getId());
    }
}
