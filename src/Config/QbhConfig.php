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
 * 歌曲识别配置参数类
 *
 * @author guizheng@iflytek.com
 */
class QbhConfig implements ConfigInterface
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * @var string 引擎类型
     * 仅支持afs
     */
    private $engine_type;

    /**
     * @var string 音频编码
     *  raw：pcm、wav格式
     *  acc
     * 默认raw
     */
    private $aue;

    /**
     * @var string 音频采样率
     * 16000/8000
     * 默认16000，aue是aac，sample_rate必须是8000
     */
    private $sample_rate;

    /**
     * @var string 哼唱音频存放地址url
     */
    private $audio_url;

    public function __construct($config)
    {
        $config += [
            'aue' => 'raw',
            'sample_rate' => "16000",
            'audio_url' => null
        ];

        $this->engine_type = 'afs';
        $this->aue = $config['aue'];
        $this->sample_rate = $config['sample_rate'];
        $this->audio_url = $config['audio_url'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return $this->removeNull([
            'engine_type' => $this->engine_type,
            'aue' => $this->aue,
            'sample_rate' => $this->sample_rate,
            'audio_url' => $this->audio_url,
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
}
