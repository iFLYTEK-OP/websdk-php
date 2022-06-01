<?php

/**
 * Copyright 1999-2022 iFLYTEK Corporation
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace IFlytek\Xfyun\Speech;

use IFlytek\Xfyun\Speech\Config\TcConfig;
use IFlytek\Xfyun\Speech\Constants\TcConstants;
use IFlytek\Xfyun\Speech\Traits\TcTrait;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use IFlytek\Xfyun\Core\HttpClient;
use GuzzleHttp\Psr7\Request;

/**
 * 文本纠错客户端
 *
 * @author guizheng@iflytek.com
 */
class TcClient
{
    use SignTrait;
    use TcTrait;

    protected $appId;
    protected $apiKey;
    protected $apiSecret;
    protected $uid;
    protected $resId;
    protected $requestConfig;
    protected $client;

    public function __construct($appId, $apiKey, $apiSecret, $uid = null, $resId = null, $requestConfig = [])
    {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->uid = $uid;
        $this->resId = $resId;
        $this->requestConfig = new TcConfig($requestConfig);
        $this->client = new HttpClient([]);
    }

    public function request($text)
    {
        $uri = self::signUriV1(TcConstants::URI, [
            'apiKey' => $this->apiKey,
            'apiSecret' => $this->apiSecret,
            'host' => TcConstants::HOST,
            'requestLine' => TcConstants::REQUEST_LINE
        ]);
        $body = self::generateInput($text, $this->appId, $this->uid, $this->resId, $this->requestConfig->toArray());
        return $this->client->sendAndReceive(
            new Request(
                'POST',
                $uri,
                ['Content-Type' => 'application/json;charset=UTF-8'],
                $body
            )
        );
    }

    public function listUpload($whiteList, $blackList)
    {
        if (empty($this->uid) || empty($this->resId)) {
            return false;
        }
        $response = $this->client->sendAndReceive(
            new Request(
                'POST',
                TcConstants::LIST_UPLOAD_URI,
                ['Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'],
                self::jsonEncode([
                    'common' => [
                        'app_id' => $this->appId,
                        'uid' => $this->uid,

                    ],
                    'business' => [
                        'res_id' => $this->resId
                    ],
                    'data' => base64_encode(self::jsonEncode([
                        'white_list' => $whiteList,
                        'black_list' => $blackList
                    ]))
                ])
            )
        );
        $content = json_decode($response->getBody()->getContents(), true);
        return $content['message'] == 'success';
    }
}
