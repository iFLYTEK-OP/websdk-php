<?php

/**
 * Copyright 1999-2021 iFLYTEK Corporation

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace IFlytek\Xfyun\Speech\Config;

use IFlytek\Xfyun\Core\Traits\ArrayTrait;
use IFlytek\Xfyun\Core\Config\ConfigInterface;

/**
 * 文本纠错配置参数类
 *
 * @author guizheng@iflytek.com
 */
class TcConfig implements ConfigInterface
{
    use ArrayTrait;

    private $resultEncoding;
    private $resultCompress;
    private $resultFormat;

    private $inputEncoding;
    private $inputCompress;
    private $inputFormat;

    public function __construct($config)
    {
        $config += [
            'resultEncoding' => 'utf8',
            'resultCompress' => 'raw',
            'resultFormat' => 'json',
            'inputEncoding' => 'utf8',
            'inputCompress' => 'raw',
            'inputFormat' => 'json'
        ];

        $this->resultEncoding = $config['resultEncoding'];
        $this->resultCompress = $config['resultCompress'];
        $this->resultFormat = $config['resultFormat'];
        $this->inputEncoding = $config['inputEncoding'];
        $this->inputCompress = $config['inputCompress'];
        $this->inputFormat = $config['inputFormat'];
    }

    public function toJson()
    {
        // TODO: Implement toJson() method.
    }

    public function toArray()
    {
        return self::removeNull([
            'resultEncoding' => $this->resultEncoding,
            'resultCompress' => $this->resultCompress,
            'resultFormat' => $this->resultFormat,
            'inputEncoding' => $this->inputEncoding,
            'inputCompress' => $this->inputCompress,
            'inputFormat' => $this->inputFormat
        ]);
    }
}
