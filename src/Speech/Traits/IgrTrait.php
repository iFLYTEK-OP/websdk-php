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
 * 性别年龄识别方法
 *
 * @author guizheng@iflytek.com
 */
trait IgrTrait
{
    use ArrayTrait;
    use JsonTrait;

    /**
     * 根据音频数据、是否是第一帧、最后一帧，生成音频上传请求体
     *
     * @param string $frameData 音频数据
     * @param boolean $isFirstFrame 是否是第一帧
     * @param boolean $isLastFrame 是否是最后一帧
     * @return  string
     */
    public function generateAudioInput($frameData, $isFirstFrame = false, $isLastFrame = false)
    {
        return self::jsonEncode(
            self::removeNull([
                "common" => !$isFirstFrame ? null : [
                    "app_id" => $this->appId
                ],
                'business' => !$isFirstFrame ? null : [
                    "aue" => $this->requestConfig->getAue(),
                    "rate" => $this->requestConfig->getRate()
                ],
                'data' => [
                    'status' => $isFirstFrame ? 0 : ($isLastFrame ? 2 : 1),
                    'audio' => base64_encode($frameData)
                ]
            ])
        );
    }
}
