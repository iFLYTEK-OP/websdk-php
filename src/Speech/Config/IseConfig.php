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
 * 语音评测配置参数类
 *
 * @author guizheng@iflytek.com
 */
class IseConfig implements ConfigInterface
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * @var string 服务类型指定
     * ise: 开放评测
     * 默认'ise'
     */
    private $sub;

    /**
     * @var string 评测语种
     * 中文：cn_vip，英文：en_vip
     * 默认'cn_vip'
     */
    private $ent;

    /**
     * @var string 评测题型
     * 中文题型：
     *  read_syllable（单字朗读，汉语专有）
     *  read_word（词语朗读）
     *  read_sentence（句子朗读）
     *  read_chapter(篇章朗读)
     * 英文题型：
     *  read_word（词语朗读）
     *  read_sentence（句子朗读）
     *  read_chapter(篇章朗读)
     *  simple_expression（英文情景反应）
     *  read_choice（英文选择题）
     *  topic（英文自由题）
     *  retell（英文复述题）
     *  picture_talk（英文看图说话）
     *  oral_translation（英文口头翻译）
     * 默认read_sentence
     */
    private $category;

    /**
     * @var int 上传音频时来区分音频的状态
     * 1/2/4
     * 默认1
     */
    private $aus;

    /**
     * @var string 用来区分数据上传阶段
     *  ssb：参数上传阶段
     *  ttp：文本上传阶段（ttp_skip=true时该阶段可以跳过，直接使用text字段中的文本）
     *  auw：音频上传阶段
     * 必传
     */
    private $cmd;

    /**
     * @var string 待评测文本
     * 需要加utf8bom头：'\uFEFF' + text
     */
    private $text;

    /**
     * @var string 带评测文本编码
     * utf-8/gbk
     * 默认utf-8
     */
    private $tte;

    /**
     * @var boolean 跳过ttp直接使用text中的文本进行评测
     * true/false
     * 默认true
     */
    private $ttpSkip;

    /**
     * @var string 拓展能力（生效条件ise_unite="1", rst="entirety"）
     * 多维度分信息显示（准确度分、流畅度分、完整度打分）：extra_ability值为multi_dimension，字词句篇均适用，如选多个能力，用分号；隔开。例如：extra_ability=syll_phone_err_msg;pitch;multi_dimension
     * 单词基频信息显示（基频开始值、结束值）：extra_ability值为pitch ，仅适用于单词和句子题型
     * 音素错误信息显示（声韵、调型是否正确）：extra_ability值为syll_phone_err_msg，字词句篇均适用,如选多个能力，用分号；隔开。例如：extra_ability=syll_phone_err_msg;pitch;multi_dimension
     */
    private $extraAbility;

    /**
     * @var string 音频格式
     * raw: 未压缩的pcm格式音频或wav（如果用wav格式音频，建议去掉头部）
     * lame: mp3格式音频
     * speex-wb;7: 讯飞定制speex格式音频
     * 默认speex-wb
     */
    private $aue;

    /**
     * @var string 音频采样率
     * 默认 audio/L16;rate=16000
     */
    private $auf;

    /**
     * @var string 返回结果格式
     * utf8/gbk
     * 默认utf8
     */
    private $rstcd;

    /**
     * @var string 评测人群指定
     * adult（成人群体，不设置群体参数时默认为成人）
     * youth（中学群体）
     * pupil（小学群体，中文句、篇题型设置此参数值会有accuracy_score得分的返回）
     * 默认adult
     */
    private $group;

    /**
     * @var string 设置评测的打分及检错松严门限（仅中文引擎支持）
     * easy：容易
     * common：普通
     * hard：困难
     */
    private $checkType;

    /**
     * @var string 设置评测的学段参数 （仅中文题型：中小学的句子、篇章题型支持）
     * junior(1,2年级)
     * middle(3,4年级)
     * senior(5,6年级)
     */
    private $grade;

    /**
     * @var string 评测返回结果与分制控制（评测返回结果与分制控制也会受到ise_unite与plev参数的影响）
     * 完整：entirety（默认值）
     *  中文百分制推荐传参（rst="entirety"且ise_unite="1"且配合extra_ability参数使用）
     *  英文百分制推荐传参（rst="entirety"且ise_unite="1"且配合extra_ability参数使用）
     * 精简：plain（评测返回结果将只有总分）
     */
    private $rst;

    /**
     * @var string 返回结果控制
     * 0：不控制（默认值）
     * 1：控制（extra_ability参数将影响全维度等信息的返回）
     */
    private $iseUnite;

    /**
     * @var string 在rst="entirety"（默认值）且ise_unite="0"（默认值）的情况下plev的取值不同对返回结果有影响。
     * plev：0(给出全部信息，汉语包含rec_node_type、perr_msg、fluency_score、phone_score信息的返回；英文包含accuracy_score、serr_msg、 syll_accent、fluency_score、standard_score、pitch信息的返回)
     */
    private $plev;

    public function __construct($config)
    {
        $config += [
            'ent' => 'cn_vip',
            'category' => 'read_sentence',
            'aus' => 1,
            'cmd' => 'ssb',
            'text' => '',
            'tte' => 'utf-8',
            'ttp_skip' => true,
            'extra_ability' => null,
            'aue' => 'raw',
            'rstcd' => 'utf8',
            'group' => 'adult',
            'check_type' => 'common',
            'grade' => 'middle',
            'rst' => 'entirety',
            'ise_unite' => '0',
            'plev' => '0'
        ];

        $this->sub = 'ise';
        $this->ent = $config['ent'];
        $this->category = $config['category'];
        $this->aus = $config['aus'];
        $this->cmd = $config['cmd'];
        $this->text = chr(239) . chr(187) . chr(191) . $config['text'];
        $this->tte = $config['tte'];
        $this->ttpSkip = $config['ttp_skip'];
        $this->extraAbility = $config['extra_ability'];
        $this->aue = $config['aue'];
        $this->rstcd = $config['rstcd'];
        $this->group = $config['group'];
        $this->checkType = $config['check_type'];
        $this->grade = $config['grade'];
        $this->rst = $config['rst'];
        $this->iseUnite = $config['ise_unite'];
        $this->plev = $config['plev'];
    }

    /**
     * 去除null项后返回数组形式
     *
     * @return array
     */
    public function toArray()
    {
        return $this->removeNull([
            'sub' => $this->sub,
            'ent' => $this->ent,
            'category' => $this->category,
            'aus' => $this->aus,
            'cmd' => $this->cmd,
            'text' => $this->text,
            'tte' => $this->tte,
            'ttp_skip' => $this->ttpSkip,
            'extra_ability' => $this->extraAbility,
            'aue' => $this->aue,
            'rstcd' => $this->rstcd,
            'group' => $this->group,
            'check_type' => $this->checkType,
            'grade' => $this->grade,
            'rst' => $this->rst,
            'ise_unite' => $this->iseUnite,
            'plev' => $this->plev
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

    public function setText($text)
    {
        $this->text = chr(239) . chr(187) . chr(191) . $text;
    }
}
