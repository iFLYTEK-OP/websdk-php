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
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/IgrDemo.php)
##### 合成参数

