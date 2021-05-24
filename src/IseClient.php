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

namespace IFlytek\Xfyun\Speech;

use IFlytek\Xfyun\Speech\Config\IseConfig;
use IFlytek\Xfyun\Speech\Constants\IseConstants;
use IFlytek\Xfyun\Core\Handler\WsHandler;
use IFlytek\Xfyun\Core\WsClient;
use IFlytek\Xfyun\Core\Traits\SignTrait;

/**
 * 语音评测客户端
 *
 * @author guizheng@iflytek.com
 */
class IseClient
{
    use SignTrait;

    /**
     * @var string app_id
     */
    protected $appId;

    /**
     * @var string api_key
     */
    protected $apiKey;

    /**
     * @var string api_secret
     */
    protected $apiSecret;

    /**
     * @var array 评测参数配置
     */
    protected $requestConfig;

    public function __construct($appId, $apiKey, $apiSecret, $requestConfig = [])
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->requestConfig = new IseConfig($requestConfig);
    }

    /**
     * 请求评测，并返回结果(字节数组)在Response->getBody()->getContents()
     *
     * @param   string  $audioPath  待评测音频路径
     * @param   string  $text       待评测文本
     * @return  GuzzleHttp/Psr7/Response
     */
    public function request($audioPath, $text)
    {
        $ttsHandler = new WsHandler(
            $this->signUriV1(IseConstants::URI, [
                'appId' => $this->appId,
                'apiKey' => $this->apiKey,
                'apiSecret' => $this->apiSecret,
                'host' => IseConstants::HOST,
                'requestLine' => IseConstants::REQUEST_LINE,
            ]),
            NULL
        );
        $client = new WsClient([
            'handler' => $ttsHandler
        ]);
        var_dump($client);exit;
    }
}
