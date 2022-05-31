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
 * 文本纠错方法
 *
 * @author guizheng@iflytek.com
 */
trait TcTrait
{
    use ArrayTrait;
    use JsonTrait;

    public static function generateInput($text, $appId, $uid, $resId, $tcConfigArray)
    {
        return self::jsonEncode(
            self::removeNull([
                'header' => [
                    'app_id' => $appId,
                    'uid' => $uid,
                    'status' => 3
                ],
                'parameter' => [
                    's9a87e3ec' => [
                        'res_id' => $resId,
                        'result' => [
                            'encoding' => $tcConfigArray['resultEncoding'],
                            'compress' => $tcConfigArray['resultCompress'],
                            'format' => $tcConfigArray['resultFormat'],
                        ]
                    ]
                ],
                'payload' => [
                    'input' => [
                        'encoding' => $tcConfigArray['inputEncoding'],
                        'compress' => $tcConfigArray['inputCompress'],
                        'format' => $tcConfigArray['inputFormat'],
                        'status' => 3,
                        'text' => base64_encode($text)
                    ]
                ]
            ])
        );
    }
}
