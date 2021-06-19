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

namespace IFlytek\Xfyun\Speech\Traits;

use IFlytek\Xfyun\Core\Traits\ArrayTrait;
use IFlytek\Xfyun\Core\Traits\JsonTrait;

/**
 * 语音合成方法
 *
 * @author guizheng@iflytek.com
 */
trait TtsTrait
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * 根据合成内容、app_id、配置参数，生成请求体
     *
     * @param string $text 带合成的文本
     * @param string $appId app_id
     * @param array $ttsConfigArray 语音合成参数，详见TtsConfig
     * @return  string
     */
    public static function generateInput($text, $appId, $ttsConfigArray)
    {
        return self::jsonEncode(
            self::removeNull([
                'common' => [
                    'app_id' => $appId
                ],
                'business' => $ttsConfigArray,
                'data' => [
                    'text' => base64_encode($text),
                    'status' => 2
                ]
            ])
        );
    }
}
