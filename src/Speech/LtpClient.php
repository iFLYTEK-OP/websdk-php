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
use IFlytek\Xfyun\Speech\Config\LfasrConfig;
use IFlytek\Xfyun\Speech\Constants\LfasrConstants;
use IFlytek\Xfyun\Speech\Constants\LtpConstants;
use IFlytek\Xfyun\Speech\Traits\LfasrTrait;
use IFlytek\Xfyun\Speech\Helper\SliceIdGenerator;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use IFlytek\Xfyun\Core\HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\MultipartStream;

/**
 * 词法分析客户端
 *
 * @author guizheng@iflytek.com
 */
class LtpClient
{
    use SignTrait;
    use JsonTrait;

    /**
     * @var string app_id
     */
    protected $appId;

    /**
     * @var string secret_key
     */
    protected $apiKey;

    /**
     * @var array 转写参数配置
     */
    protected $requestConfig;

    /** @var HttpClient */
    protected $client;

    /*** @var array 请求头 */
    protected $requestHeaders;

    /** @var array 初始化请求体 */
    protected $requestBody;

    public function __construct($appId, $apiKey, $requestConfig = [])
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->client = new HttpClient([]);
        $timestamp = time();
        $this->requestHeaders = $this->signV2($appId, $apiKey, self::jsonEncode(['type' => 'dependent']), $timestamp);
        $this->requestBody = [];
    }

    public function request($func, $text)
    {
        if (!in_array($func, LtpConstants::FUNC)) {
            throw new Exception("不支持的词法分析模块");
        }

        $this->requestHeaders += ['Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'];
        $this->requestBody += ['text' => $text];
        return $this->client->sendAndReceive(
            new Request(
                'POST',
                sprintf(LtpConstants::URI, $func),
                $this->requestHeaders,
                Query::build($this->requestBody)
            )
        );
    }
}
