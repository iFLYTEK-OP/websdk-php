#### 性别年龄识别
##### 示例代码
```php
<?php
include './vendor/autoload.php';

// 设置识别参数
$ttsConfig = [
    'aue' => 'raw',
    'rate' => 16000
    //...  
];

// 这里的$app_id、$api_key、$api_secret是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\IgrClient($app_id, $api_key, $api_secret, $ttsConfig);

// 返回识别结果
$content = $client->request('./test.pcm');
```
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/src/IgrDemo.php)
##### 合成参数
|参数名|类型|必传|描述|
|:-------------|:-------------|:-------------|:-------------|
|ent|string|是|引擎类型，目前仅支持igr|
|aue|string|是|音频格式<br>raw：原生音频数据pcm格式<br>speex：speex格式（rate需设置为8000）<br>speex-wb：宽频speex格式（rate需设置为16000）<br>amr：amr格式（rate需设置为8000）<br>amr-wb：宽频amr格式（rate需设置为16000）
|rate|int|是|音频采样率 16000/8000|
