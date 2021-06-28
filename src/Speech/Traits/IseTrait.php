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
 * 语音评测方法
 *
 * @author guizheng@iflytek.com
 */
trait IseTrait
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * 根据合成内容、app_id、配置参数，生成请求体
     *
     * @param string $appId app_id
     * @param array $iseConfigArray 语音合成参数，详见iseConfig
     * @return  string
     */
    public static function generateParamsInput($appId, $iseConfigArray)
    {
        return self::jsonEncode(
            self::removeNull([
                'common' => [
                    'app_id' => $appId
                ],
                'business' => $iseConfigArray,
                'data' => [
                    'status' => 0
                ]
            ])
        );
    }

    /**
     * 根据音频数据、是否是第一帧、最后一帧，生成音频上传请求体
     *
     * @param string $frameData 音频数据
     * @param boolean $isFirstFrame 是否是第一帧
     * @param boolean $isLastFrame 是否是最后一帧
     * @return  string
     */
    public static function generateAudioInput($frameData, $isFirstFrame = false, $isLastFrame = false)
    {
        return self::jsonEncode(
            self::removeNull([
                'business' => [
                    "cmd" => "auw",
                    "aus" => $isFirstFrame ? 1 : ($isLastFrame ? 4 : 2)
                ],
                'data' => [
                    'status' => $isLastFrame ? 2 : 1,
                    'data' => base64_encode($frameData)
                ]
            ])
        );
    }
}
