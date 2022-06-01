#### 文本纠错
##### 示例代码
```php
<?php
include './vendor/autoload.php';

use IFlytek\Xfyun\Speech\TcClient;

// 这里的$app_id、$api_key、$api_secret是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\TtsClient($app_id, $api_key, $api_secret);

// 文本纠错请求，返回格式为json字符串
$content = $client->request('历史上有很多注明的人物，其中唐太宗李世民就是一位。')->getBody()->getContents();

// 黑白名单上传请求，成功返回true，失败返回false（失败请检查uid、res_id是否设置）
$client = new IFlytek\Xfyun\Speech\TtsClient($app_id, $api_key, $api_secret, $uid, $res_id);
$client->listUpload($white_list, $black_list);
```

##### 合成参数
暂无可配置的参数
