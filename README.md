# 讯飞开放平台AI能力-PHPSDK语音能力库

[![Build Status](https://www.travis-ci.com/iFLYTEK-OP/websdk-php-speech.svg?branch=master)](https://www.travis-ci.com/iFLYTEK-OP/websdk-php-speech)[![codecov](https://codecov.io/gh/iFLYTEK-OP/websdk-php-speech/branch/master/graph/badge.svg?token=KrohBqwVKb)](https://codecov.io/gh/iFLYTEK-OP/websdk-php-speech)

提供各种语音能力的PHPSDK。

### 安装
```sh
composer require iflytekop/xfyun-speech
```
如果下载失败，请使用如下命令更换国内源

`composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/`

### 使用
#### 语音合成
##### 示例代码
```php
<?php
include './vendor/autoload.php';

// 设置合成参数
$ttsConfig = [
    'aue' => 'lame'
    //...  
];

// 这里的$app_id、$api_key、$api_secret是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\TtsClient($app_id, $api_key, $api_secret, $ttsConfig);

// 返回格式为音频文件的二进制数组，可以直接通过file_put_contents存入本地文件
$content = $client->request('欢迎使用科大讯飞语音能力，让我们一起用人工智能改变世界')->getBody()->getContents();
```
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/TtsDemo.php)
##### 合成参数
|参数名|类型|必传|描述|示例|
|---|---|---|---|---|
|aue|string|是|音频编码，可选值：<br>raw：未压缩的pcm<br>lame：mp3 **(当aue=lame时需传参sfl=1)**<br>speex-org-wb;7： 标准开源speex（for speex_wideband，即16k）数字代表指定压缩等级（默认等级为8）<br>speex-org-nb;7： 标准开源speex（for speex_narrowband，即8k）数字代表指定压缩等级（默认等级为8）<br>speex;7：压缩格式，压缩等级1-10，默认为7（8k讯飞定制speex）<br>speex-wb;7：压缩格式，压缩等级1-10，默认为7（16k讯飞定制speex）<br>|"raw" <br>"speex-org-wb;7" 数字代表指定压缩等级（默认等级为8），数字必传<br>标准开源speex编码以及讯飞定制speex说明请参考[音频格式说明](https://www.xfyun.cn/doc/asr/voicedictation/Audio.html#speex%E7%BC%96%E7%A0%81)|
|sfl|int|否|需要配合aue=lame使用，开启流式返回<br>mp3格式音频<br>取值：1 开启|1|
|auf|string|否|音频采样率，可选值：<br> audio/L16;rate=8000：合成8K 的音频<br> audio/L16;rate=16000：合成16K 的音频<br>auf不传值：合成16K 的音频|"audio/L16;rate=16000"|
|vcn|string|是|发音人，可选值：请到控制台添加试用或购买发音人，添加后即显示发音人参数值|"xiaoyan"|
|speed|int|否|语速，可选值：[0-100]，默认为50|50|
|volume|int|否|音量，可选值：[0-100]，默认为50|50|
|pitch|int|否|音高，可选值：[0-100]，默认为50|50|
|bgs|int|否|合成音频的背景音<br>0:无背景音（默认值） <br>1:有背景音|0|
|tte|string|否|文本编码格式<br>GB2312<br>GBK<br>BIG5<br>UNICODE(小语种必须使用UNICODE编码，合成的文本需使用utf16小端的编码方式<br>GB18030<br>UTF8|"UTF8"|
|reg|string|否|设置英文发音方式：<br>0：自动判断处理，如果不确定将按照英文词语拼写处理（缺省）<br>1：所有英文按字母发音<br>2：自动判断处理，如果不确定将按照字母朗读<br>默认按英文单词发音|"2"|
|rdn|string|否|合成音频数字发音方式<br>0：自动判断（默认值）<br>1：完全数值<br>2：完全字符串<br>3：字符串优先|"0"|

#### 语音转写
##### 示例代码
```php
<?php
include './vendor/autoload.php';

// 设置转写参数
$lfasrConfig = [
    'hasParticiple' => 'true'
    //...  
];

// 这里的$app_id、$secret_key是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\LfasrClient($app_id, $secret_key, $lfasrConfig);

// $filePath为待转写的本地文件路径，返回taskId作为后续查询进度、获取结果操作的参数
$taskId = $client->combineUpload($filePath);

// 查询进度，json格式
$progress = $client->getProgress($taskId)->getBody()->getContents();

// 获取结果，json格式
$result = $client->getResult($taskId)->getBody()->getContents();
```
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/LfasrDemo.php)
##### 合成参数
|参数|类型|必须|说明|示例|
|:-------------|:-------------|:-------------|:-------------|:-------------|
|lfasrType|string|否|转写类型，默认 0<br/>0:  (标准版，格式: wav,flac,opus,mp3,m4a)<br/>2: (电话版，已取消)|0|
|hasParticiple|string|否|转写结果是否包含分词信息|false或true， 默认false|
|maxAlternatives|string|否|转写结果中最大的候选词个数|默认：0，最大不超过5|
|speakerNumber|string|否|发音人个数，可选值：0-10，0表示盲分<br>*注*：发音人分离目前还是测试效果达不到商用标准，如测试无法满足您的需求，请慎用该功能。|默认：2（适用通话时两个人对话的场景）|
|hasSeperate|string|否|转写结果中是否包含发音人分离信息|false或true，默认为false|
|roleType|string|否|支持两种参数<br/>1: 通用角色分离<br/>2: 电话信道角色分离（适用于speaker_number为2的说话场景）|该字段只有在开通了角色分离功能的前提下才会生效，正确传入该参数后角色分离效果会有所提升。 如果该字段不传，默认采用 1 类型|
|language|string|否|语种<br>cn:中英文&中文（默认）<br>en:英文（英文不支持热词）|cn|
|pd|string|否|垂直领域个性化参数:<br>法院: court<br>教育: edu<br>金融: finance<br>医疗: medical<br>科技: tech|设置示例:prepareParam.put("pd", "edu")<br>pd为非必须设置参数，不设置参数默认为通用|
