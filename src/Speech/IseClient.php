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
use IFlytek\Xfyun\Speech\Traits\IseTrait;
use IFlytek\Xfyun\Core\Handler\WsHandler;
use IFlytek\Xfyun\Core\WsClient;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use GuzzleHttp\Psr7\Stream;

/**
 * 语音评测客户端
 *
 * @author guizheng@iflytek.com
 */
class IseClient
{
    use SignTrait;
    use IseTrait;

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
     * 请求评测，并返回结果（xml格式）
     *
     * @param string $audioPath 待评测音频路径
     * @param string $text 待评测文本
     * @return  string
     */
    public function request($audioPath, $text = null)
    {
        $ttsHandler = new WsHandler(
            $this->signUriV1(IseConstants::URI, [
                'appId' => $this->appId,
                'apiKey' => $this->apiKey,
                'apiSecret' => $this->apiSecret,
                'host' => IseConstants::HOST,
                'requestLine' => IseConstants::REQUEST_LINE,
            ]),
            null
        );
        $client = new WsClient([
            'handler' => $ttsHandler
        ]);

        // 参数上传
        if (!empty($text)) {
            $this->requestConfig->setText($text);
        }
        $client->send($this->generateParamsInput($this->appId, $this->requestConfig->toArray()));

        // 音频上传
        $frameSize = ceil(fileSize($audioPath) / IseConstants::FRAME_SIZE);
        $fileStream = new Stream(fopen($audioPath, 'r'));
        // 发送第一帧
        $result = $client->send($this->generateAudioInput($fileStream->read(IseConstants::FRAME_SIZE), true, false));
        // 发送中间帧
        for ($i = 1; $i < $frameSize - 1; $i++) {
            $client->send($this->generateAudioInput($fileStream->read(IseConstants::FRAME_SIZE), false, false));
            usleep(4000);
        }
        // 发送最后一帧
        $client->send($this->generateAudioInput($fileStream->read(IseConstants::FRAME_SIZE), false, true));

        // 接受数据
        $result = '';
        while (true) {
            $message = $this->jsonDecode($client->receive());
            if ($message->code !== 0) {
                throw new \Exception(json_encode($message));
            }
            switch ($message->data->status) {
                case 1:
                    $result .= base64_decode($message->data->data);
                    break;
                case 2:
                    $result .= base64_decode($message->data->data);
                    break 2;
            }
        }
        return $result;
    }
}
