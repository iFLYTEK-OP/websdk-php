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
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use IFlytek\Xfyun\Core\Config\ConfigInterface;

/**
 * 性别年龄识别配置参数类
 *
 * @author guizheng@iflytek.com
 */
class IgrConfig implements ConfigInterface
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * @var string 引擎类型
     * 仅支持igr
     */
    private $ent;

    /**
     * @var string 音频格式
     *  raw：原生音频数据pcm格式
     *  speex：speex格式（rate需设置为8000）
     *  speex-wb：宽频speex格式（rate需设置为16000）
     *  amr：amr格式（rate需设置为8000）
     *  amr-wb：宽频amr格式（rate需设置为16000）
     * 默认raw
     */
    private $aue;

    /**
     * @var int 音频采样率
     * 16000/8000
     * 默认16000
     */
    private $rate;

    public function __construct($config)
    {
        $config += [
            'aue' => 'raw',
            'rate' => 16000
        ];

        $this->ent = 'igr';
        $this->aue = $config['aue'];
        $this->rate = $config['rate'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return $this->removeNull([
            'ent' => $this->ent,
            'aue' => $this->aue,
            'rate' => $this->rate
        ]);
    }

    /**
     * 返回toArray的Json格式
     *
     * @return string
     */
    public function toJson()
    {
        return $this->jsonEncode($this->toArray());
    }

    /**
     * @return string
     */
    public function getAue()
    {
        return $this->aue;
    }

    /**
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }
}
