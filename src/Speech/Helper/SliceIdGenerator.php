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

namespace IFlytek\Xfyun\Speech\Helper;

use IFlytek\Xfyun\Speech\Constants\LfasrConstants;

/**
 * 转写切片ID生成类
 *
 * @author guizheng@iflytek.com
 */
class SliceIdGenerator
{
    /**
     * @var string 当前切片ID
     */
    private $id;

    public function __construct()
    {
        $this->id = LfasrConstants::ORIGIN_SLICE_ID;
    }

    /**
     * 返回当前切片ID，并生成下一个切片ID，赋值给对象的当前ID
     *
     * @return string
     */
    public function getId()
    {
        $currentId = $this->id;
        $nextId = $currentId;
        $pos = strlen($currentId) - 1;
        while ($pos >= 0) {
            $charAtPos = $nextId[$pos];
            if ($charAtPos != 'z') {
                $nextId = substr($nextId, 0, $pos) . chr((ord($charAtPos) + 1)) . substr($nextId, $pos + 1);
                break;
            } else {
                $nextId = substr($nextId, 0, $pos) . 'a';
                $pos = $pos - 1;
            }
        }
        $this->id = $nextId;
        return $currentId;
    }
}
