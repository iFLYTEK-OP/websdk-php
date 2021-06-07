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
更详细请参见[Demo](https://github.com/iFLYTEK-OP/websdk-php-demo/blob/master/src/LfasrDemo.php)
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
