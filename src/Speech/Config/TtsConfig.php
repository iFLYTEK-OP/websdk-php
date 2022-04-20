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
 * 语音合成配置参数类
 *
 * @author guizheng@iflytek.com
 */
class TtsConfig implements ConfigInterface
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * @var string 音频编码(必填)
     * raw:未压缩的pcm
     * lame:mp3 (当aue=lame时需传参sfl=1)
     * speex-org-wb;7: 标准开源speex（for speex_wideband，即16k）数字代表指定压缩等级（默认等级为8）
     * speex-org-nb;7: 标准开源speex（for speex_narrowband，即8k）数字代表指定压缩等级（默认等级为8）
     * speex;7:压缩格式，压缩等级1~10，默认为7（8k讯飞定制speex）
     * speex-wb;7:压缩格式，压缩等级1~10，默认为7（16k讯飞定制speex）
     * 本sdk将默认采用raw格式
     */
    private $aue;

    /**
     * @var int 开启流式返回
     * 需要配合aue=lame使用，开启流式返回mp3格式音频取值:1
     */
    private $sfl;

    /**
     * @var string 音频采样率
     * audio/L16;rate=8000: 合成8K的音频
     * audio/L16;rate=16000: 合成16K的音频
     * auf不传值: 合成16K的音频
     */
    private $auf;

    /**
     * @var string 发音人(必填)
     * 可选值: 请到控制台添加试用或购买
     * 默认xiaoyan
     */
    private $vcn;

    /**
     * @var int 语速
     * 可选值: 0-100
     * 默认为50
     */
    private $speed;

    /**
     * @var int 音量
     * 可选值: 0-100
     * 默认为50
     */
    private $volume;

    /**
     * @var int 音高
     * 可选值: 0-100
     * 默认为50
     */
    private $pitch;

    /**
     * @var int 合成音频的背景音
     * 0: 无背景音; 1: 有背景音
     * 默认0
     */
    private $bgs;

    /**
     * @var string 文本编码格式
     * GB2312|GBK|BIG5|UNICODE|GB18030|UTF8
     * 默认UTF-8
     */
    private $tte;

    /**
     * @var string 设置英文发音方式
     * 0: 自动判断处理，如果不确定将按照英文词语拼写处理
     * 1: 所有英文按字母发音
     * 2: 自动判断处理，如果不确定将按照字母朗读
     * 默认2
     */
    private $reg;

    /**
     * @var string 合成音频数字发音方式
     * 0: 自动判断
     * 1: 完全数值
     * 2: 完全字符串
     * 3: 字符串优先
     * 默认0
     */
    private $rdn;

    /**
     * @var string 自定义发音人引擎
     * 默认传 ptts
     */
    private $ent;

    public function __construct($config = [])
    {
        $config += [
            'aue' => 'lame',
            'sfl' => 1,
            'auf' => null,
            'vcn' => 'xiaoyan',
            'speed' => 50,
            'volume' => 50,
            'pitch' => 50,
            'bgs' => 0,
            'tte' => 'UTF8',
            'reg' => '2',
            'rdn' => '0',
            'ent' => ''
        ];

        $this->aue = $config['aue'];
        $this->sfl = $config['sfl'];
        $this->auf = $config['auf'];
        $this->vcn = $config['vcn'];
        $this->speed = $config['speed'];
        $this->volume = $config['volume'];
        $this->pitch = $config['pitch'];
        $this->bgs = $config['bgs'];
        $this->tte = $config['tte'];
        $this->reg = $config['reg'];
        $this->rdn = $config['rdn'];
        $this->ent = $config['ent'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return $this->removeNull([
            'aue' => $this->aue,
            'sfl' => $this->sfl,
            'auf' => $this->auf,
            'vcn' => $this->vcn,
            'speed' => $this->speed,
            'volume' => $this->volume,
            'pitch' => $this->pitch,
            'bgs' => $this->bgs,
            'tte' => $this->tte,
            'reg' => $this->reg,
            'rdn' => $this->rdn,
            'ent' => $this->ent
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
