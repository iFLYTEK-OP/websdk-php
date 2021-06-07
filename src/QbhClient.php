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
use IFlytek\Xfyun\Speech\Config\QbhConfig;
use IFlytek\Xfyun\Core\Traits\SignTrait;

/**
 * 性别年龄识别客户端
 *
 * @author guizheng@iflytek.com
 */
class QbhClient
{
    use SignTrait;
    use QbhTrait;

    /**
     * @var string
     */
    protected $appId;
    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var QbhConfig
     */
    protected $requestConfig;

    public function __construct($appId, $apiSecret, $requestConfig = [])
    {
        $this->appId = $appId;
        $this->apiSecret = $apiSecret;
        $this->requestConfig = new QbhConfig($requestConfig);
    }

    /**
     * 请求并返回结果
     *
     * @param   string  $audioPath  待识别音频路径
     * @throws  Exception
     * @return  string
     */
    public function request($audioPath)
    {
        return '';
    }
}
