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

use Exception;
use IFlytek\Xfyun\Speech\Config\TtsConfig;
use IFlytek\Xfyun\Speech\Constants\TtsConstants;
use IFlytek\Xfyun\Speech\Traits\TtsTrait;
use IFlytek\Xfyun\Core\Handler\WsHandler;
use IFlytek\Xfyun\Core\WsClient;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use Psr\Log\LoggerInterface;

/**
 * 语音合成客户端
 *
 * @author guizheng@iflytek.com
 */
class TtsClient
{
    use SignTrait;
    use TtsTrait;

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
     * @var array 合成参数配置
     */
    protected $requestConfig;

    /**
     * @var LoggerInterface or null 日志处理
     */
    protected $logger;

    public function __construct($appId, $apiKey, $apiSecret, $requestConfig = [], $logger = null)
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->requestConfig = new TtsConfig($requestConfig);
        $this->logger = $logger;
    }

    /**
     * 合成文本，并返回结果(字节数组)在Response->getBody()->getContents()
     *
     * @param string $text 待合成的文本
     * @return \GuzzleHttp\Psr7\Response
     * @throws Exception
     */
    public function request($text)
    {
        $ttsHandler = new WsHandler(
            $this->signUriV1(TtsConstants::URI, [
                'appId' => $this->appId,
                'apiKey' => $this->apiKey,
                'apiSecret' => $this->apiSecret,
                'host' => TtsConstants::HOST,
                'requestLine' => TtsConstants::REQUEST_LINE,
            ]),
            $this->generateInput($text, $this->appId, $this->requestConfig->toArray())
        );
        if ($this->logger) {
            $ttsHandler->setLogger($this->logger);
        }
        $client = new WsClient([
            'handler' => $ttsHandler
        ]);
        return $client->sendAndReceive();
    }
}
