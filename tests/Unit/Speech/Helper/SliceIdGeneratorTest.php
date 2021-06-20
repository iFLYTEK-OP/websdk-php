<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech\Helper;

use IFlytek\Xfyun\Speech\Helper\SliceIdGenerator;
use PHPUnit\Framework\TestCase;

class SliceIdGeneratorTest extends TestCase
{
    public function testSliceIdSuccessfullyGenerate()
    {
        $generator = new SliceIdGenerator();
        $this->assertEquals('aaaaaaaaaa', $generator->getId());
        $this->assertEquals('aaaaaaaaab', $generator->getId());
        $this->assertEquals('aaaaaaaaac', $generator->getId());
        for ($i = 0; $i < 23; $i++) {
            $generator->getId();
        }
        $this->assertEquals('aaaaaaaaba', $generator->getId());
        for ($i = 0; $i < 25; $i++) {
            $generator->getId();
        }
        $this->assertEquals('aaaaaaaaca', $generator->getId());
    }
}
