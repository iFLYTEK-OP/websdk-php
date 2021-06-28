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

namespace IFlytek\Xfyun\Speech\Constants;

 /**
 * 性别年龄识别常量
 *
 * @author guizheng@iflytek.com
 */
class IgrConstants
{
    public const URI = 'wss://ws-api.xfyun.cn/v2/igr';
    public const HOST = 'ws-api.xfyun.cn';
    public const REQUEST_LINE = 'GET /v2/igr HTTP/1.1';
    public const FRAME_SIZE = 1280;
}