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
 * 语音转写配置参数类
 *
 * @author guizheng@iflytek.com
 */
class LfasrConfig implements ConfigInterface
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * @var string 转写类型
     * 0: (标准版，格式: wav,flac,opus,mp3,m4a)
     * 默认: 0
     */
    private $lfasrType;

    /**
     * @var string 转写结果是否包含分词信息
     * false或true
     * 默认false
     */
    private $hasParticiple;

    /**
     * @var string 转写结果中最大的候选词个数
     * 0-5
     * 默认0
     */
    private $maxAlternatives;

    /**
     * @var string 发音人个数
     * 0-10
     * 默认2
     */
    private $speakerNumber;

    /**
     * @var string 是否包含发音人分离信息
     * false或true
     * 默认false
     */
    private $hasSeperate;

    /**
     * @var string 角色分离类型
     * 1: 通用角色分离；2: 电话信道角色分离（适用于speaker_number为2的说话场景）
     * 默认1，该字段只有在开通了角色分离功能的前提下才会生效，正确传入该参数后角色分离效果会有所提升。
     */
    private $roleType;

    /**
     * @var string 语种
     * cn: 中英文&中文；en: 英文(英文不支持热词)
     * 默认cn
     */
    private $language;

    /**
     * @var string 垂直领域个性化参数
     * court: 法院; edu: 教育; finance: 金融; medical: 医疗; tech: 科技;
     * 默认通用
     */
    private $pd;

    public function __construct($config)
    {
        $config += [
            'lfasr_type' => '0',
            'has_participle' => 'false',
            'max_alternatives' => '0',
            'speaker_number' => '2',
            'has_seperate' => 'false',
            'role_type' => '1',
            'language' => 'cn',
            'pd' => null
        ];

        $this->lfasrType = $config['lfasr_type'];
        $this->hasParticiple = $config['has_participle'];
        $this->maxAlternatives = $config['max_alternatives'];
        $this->speakerNumber = $config['speaker_number'];
        $this->hasSeperate = $config['has_seperate'];
        $this->roleType = $config['role_type'];
        $this->language = $config['language'];
        $this->pd = $config['pd'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return $this->removeNull([
            'lfasr_type' => $this->lfasrType,
            'has_participle' => $this->hasParticiple,
            'max_alternatives' => $this->maxAlternatives,
            'speaker_number' => $this->speakerNumber,
            'has_seperate' => $this->hasSeperate,
            'role_type' => $this->roleType,
            'language' => $this->language,
            'pd' => $this->pd
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
