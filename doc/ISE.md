#### 语音评测识别
##### 示例代码
```php
<?php
include './vendor/autoload.php';

// 设置评测参数
$ttsConfig = [
    'ent' => 'cn_vip'
    //...  
];

// 这里的$app_id、$api_key、$api_secret是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\IseClient($app_id, $api_key, $api_secret, $ttsConfig);

// 返回识别结果
$content = $client->request('欢迎使用科大讯飞语音能力', './test.pcm');
```
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/src/IseDemo.php)
##### 合成参数
|参数|类型|必须|说明|示例|
|:-------------|:-------------|:-------------|:-------------|:-------------|
|aue|string|是|音频编码<br>raw（未压缩的 pcm 格式音频）<br>speex（标准开源speex）|raw|
|speex_size|string|否|标准speex解码帧的大小<br>当aue=speex时，若传此参数，表明音频格式为标准speex<br>解码帧大小请参考[这里](#speex编码)；|70|
|result_level|string|否|评测结果等级<br>entirety（默认值）<br>simple|entirety|
|language|string|是|评测语种<br>en_us（英语）<br>zh_cn（汉语）|zh_cn|
|category|string|是|评测题型<br>read_syllable（单字朗读，汉语专有）<br>read_word（词语朗读）<br>read_sentence（句子朗读）<br>read_chapter(篇章朗读)|read_sentence|
|extra_ability|string|否|拓展能力<br>multi_dimension([全维度](#全维度说明) )|multi_dimension|
