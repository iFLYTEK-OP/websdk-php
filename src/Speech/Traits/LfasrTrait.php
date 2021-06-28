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

use IFlytek\Xfyun\Speech\Constants\LfasrConstants;

/**
 * 转写方法
 *
 * @author guizheng@iflytek.com
 */
trait LfasrTrait
{
    /**
     * 获取文件名和文件大小
     *
     * @param string $filePath 文件路径
     * @return  array
     */
    public static function fileInfo($filePath)
    {
        return [
            'file_name' => basename($filePath),
            'file_len' => filesize($filePath)
        ];
    }

    /**
     * 根据文件大小和SDK默认分片大小，获取文件分片数目信息
     *
     * @param string $filePath 文件路径
     * @return  array
     */
    public static function sliceInfo($filePath)
    {
        $fileSize = filesize($filePath);
        return [
            'slice_num' => ceil($fileSize / LfasrConstants::SLICE_PIECE_SIZE)
        ];
    }
}
