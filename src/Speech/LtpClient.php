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
use GuzzleHttp\Psr7\Response;
use IFlytek\Xfyun\Speech\Constants\LtpConstants;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use IFlytek\Xfyun\Core\HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Query;

/**
 * 词法分析客户端
 * https://www.xfyun.cn/doc/nlp/semanticDependence/API.html#%E6%8E%A5%E5%8F%A3%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0
 *
 * @author xinxiong2@iflytek.com
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
     * @var string api_key
     */
    protected $apiKey;

    /** @var HttpClient */
    protected $client;

    /*** @var array 请求头 */
    protected $requestHeaders;

    /** @var array 初始化请求体 */
    protected $requestBody;

    public function __construct($appId, $apiKey)
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->client = new HttpClient([]);
        $timestamp = time();
        $param = self::jsonEncode(['type' => 'dependent']);
        $this->requestHeaders = $this->signV2($appId, $apiKey, $param, $timestamp);
        $this->requestBody = [];
    }

    /**
     * @param $func string 词法分析模块名，
     * @param $text string 待分析文本，长度限制为500字节(中文简体)
     * @return Response
     * @throws Exception
     */
    public function request(string $func, string $text): Response
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
