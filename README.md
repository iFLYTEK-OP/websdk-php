# 讯飞开放平台AI能力-PHPSDK语音能力库

[![Build Status](https://www.travis-ci.com/iFLYTEK-OP/websdk-php-speech.svg?branch=master)](https://www.travis-ci.com/iFLYTEK-OP/websdk-php-speech)[![codecov](https://codecov.io/gh/iFLYTEK-OP/websdk-php-speech/branch/main/graph/badge.svg?token=KrohBqwVKb)](https://codecov.io/gh/iFLYTEK-OP/websdk-php-speech)

提供各种语音能力的PHPSDK。

### 安装
```sh
composer require IFlytek/Xfyun/Speech
```

### 使用
##### 语音合成
```php
<?php
include './vendor/autoload.php';

// 这里的$app_id、$api_key、$api_secret是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\SpeechClient($app_id, $api_key, $api_secret);

// 返回格式为音频文件的二进制数组，可以直接通过file_put_contents存入本地文件
$content = $client->ttsRequest('欢迎使用科大讯飞语音能力，让我们一起用人工智能改变世界')->getBody()->getContents();
```

##### 语音转写
```php
<?php
include './vendor/autoload.php';

// 这里的$app_id、$secret_key是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\LfasrClient($app_id, $secret_key);

// $filePath为待转写的本地文件路径，返回taskId作为后续查询进度、获取结果操作的参数
$taskId = $client->combineUpload($filePath);

// 查询进度，json格式
$progress = $client->getProgress($taskId)->getBody()->getContents();

// 获取结果，json格式
$result = $client->getResult($taskId)->getBody()->getContents();
```
