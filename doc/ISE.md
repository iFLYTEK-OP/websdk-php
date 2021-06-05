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
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/IseDemo.php)
##### 合成参数

