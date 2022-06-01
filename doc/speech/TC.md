#### 文本纠错
##### 示例代码
```php
<?php
include './vendor/autoload.php';

use IFlytek\Xfyun\Speech\TcClient;

// 这里的$app_id、$api_key、$api_secret是在开放平台控制台获得
$client = new IFlytek\Xfyun\Speech\TtsClient($app_id, $api_key, $api_secret);

// 返回格式为json字符串
$content = $client->request('历史上有很多注明的人物，其中唐太宗李世民就是一位。')->getBody()->getContents();
```

##### 合成参数
暂无可配置的参数
