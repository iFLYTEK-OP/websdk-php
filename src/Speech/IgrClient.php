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
use IFlytek\Xfyun\Speech\Config\IgrConfig;
use IFlytek\Xfyun\Speech\Constants\IgrConstants;
use IFlytek\Xfyun\Speech\Traits\IgrTrait;
use IFlytek\Xfyun\Core\Handler\WsHandler;
use IFlytek\Xfyun\Core\WsClient;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use GuzzleHttp\Psr7\Stream;

/**
 * 性别年龄识别客户端
 *
 * @author guizheng@iflytek.com
 */
class IgrClient
{
    use SignTrait;
    use IgrTrait;

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
     * @var IgrConfig
     */
    protected $requestConfig;

    public function __construct($appId, $apiKey, $apiSecret, $requestConfig = [])
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->requestConfig = new IgrConfig($requestConfig);
    }

    /**
     * 请求并返回结果
     *
     * @param string $audioPath 待识别音频路径
     * @return  string
     * @throws  Exception
     */
    public function request($audioPath)
    {
        $ttsHandler = new WsHandler(
            $this->signUriV1(IgrConstants::URI, [
                'appId' => $this->appId,
                'apiKey' => $this->apiKey,
                'apiSecret' => $this->apiSecret,
                'host' => IgrConstants::HOST,
                'requestLine' => IgrConstants::REQUEST_LINE,
            ]),
            null
        );
        $client = new WsClient([
            'handler' => $ttsHandler
        ]);

        // 音频上传
        $frameNum = ceil(fileSize($audioPath) / IgrConstants::FRAME_SIZE);
        $fileStream = new Stream(fopen($audioPath, 'r'));
        // 发送第一帧
        $client->send($this->generateAudioInput($fileStream->read(IgrConstants::FRAME_SIZE), true, false));

        // 发送中间帧
        for ($i = 1; $i < $frameNum; $i++) {
            $client->send($this->generateAudioInput($fileStream->read(IgrConstants::FRAME_SIZE), false, false));
            usleep(4000);
        }
        // 发送最后一帧
        $client->send($this->generateAudioInput('', false, true));

        // 接受数据
        $message = $this->jsonDecode($client->receive(), true);
        if ($message['code'] !== 0) {
            throw new Exception(json_encode($message));
        }
        return $message['data'];
    }
}
