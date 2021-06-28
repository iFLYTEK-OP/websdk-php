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
use IFlytek\Xfyun\Speech\Config\LfasrConfig;
use IFlytek\Xfyun\Speech\Constants\LfasrConstants;
use IFlytek\Xfyun\Speech\Traits\LfasrTrait;
use IFlytek\Xfyun\Speech\Helper\SliceIdGenerator;
use IFlytek\Xfyun\Core\Traits\SignTrait;
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use IFlytek\Xfyun\Core\HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\MultipartStream;

/**
 * 语音转写客户端
 *
 * @author guizheng@iflytek.com
 */
class LfasrClient
{
    use SignTrait;
    use JsonTrait;
    use LfasrTrait;

    /**
     * @var string app_id
     */
    protected $appId;

    /**
     * @var string secret_key
     */
    protected $secretKey;

    /**
     * @var array 转写参数配置
     */
    protected $requestConfig;

    /** @var HttpClient */
    protected $client;

    /** @var array 初始化请求体 */
    protected $requestBody;

    public function __construct($appId, $secretKey, $requestConfig = [])
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;
        $this->requestConfig = new LfasrConfig($requestConfig);
        $this->client = new HttpClient([]);
        $timestamp = time();
        $this->requestBody = [
            'app_id' => $this->appId,
            'signa' => $this->signV1($this->appId, $this->secretKey, $timestamp),
            'ts' => $timestamp,
        ];
    }

    /**
     * 打包上传接口，封装了准备、分片上传和合并三个接口，并返回task_id
     *
     * @param string $filePath 文件路径
     * @return  string
     * @throws Exception
     */
    public function combineUpload($filePath)
    {
        $prepareResponse = $this->prepare($filePath);
        $prepareContent = $this->jsonDecode($prepareResponse->getBody()->getContents(), true);
        $taskId = $prepareContent['data'];
        $this->upload($taskId, $filePath);
        $this->merge($taskId);
        return $taskId;
    }

    /**
     * 准备接口
     *
     * @param $file_path
     * @return  Response
     * @throws Exception
     */
    public function prepare($file_path)
    {
        $this->requestBody += $this->fileInfo($file_path);
        $this->requestBody += $this->sliceInfo($file_path);
        $this->requestBody += $this->requestConfig->toArray();

        return $this->client->sendAndReceive(
            new Request(
                'POST',
                LfasrConstants::URI_PREPARE,
                ['Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'],
                Query::build($this->requestBody)
            )
        );
    }

    /**
     * 分片上传接口
     *
     * @param string $taskId task_id
     * @param string $filePath 文件路径
     * @return  Response
     * @throws Exception
     */
    public function upload($taskId, $filePath)
    {
        $sliceIdGenerator = new SliceIdGenerator();
        $sliceInfo = $this->sliceInfo($filePath);
        $fileStream = new Stream(fopen($filePath, 'r'));

        $this->requestBody += [
            'task_id' => $taskId
        ];

        $request = new Request(
            'POST',
            LfasrConstants::URI_UPLOAD
        );

        for ($i = 0; $i < $sliceInfo['slice_num']; $i++) {
            $multipartStream = new MultipartStream([
                [
                    'name' => 'app_id',
                    'contents' => $this->requestBody['app_id']
                ],
                [
                    'name' => 'signa',
                    'contents' => $this->requestBody['signa']
                ],
                [
                    'name' => 'ts',
                    'contents' => $this->requestBody['ts']
                ],
                [
                    'name' => 'task_id',
                    'contents' => $taskId,
                ],
                [
                    'name' => 'slice_id',
                    'contents' => $sliceIdGenerator->getId()
                ],
                [
                    'name' => 'content',
                    'contents' => $fileStream->read(LfasrConstants::SLICE_PIECE_SIZE),
                    'filename' => '1.pcm'
                ]
            ]);

            $this->client->sendAndReceive(
                $request->withBody($multipartStream)
            );
        }
        return new Response(200);
    }

    /**
     * 合并接口
     *
     * @param string $taskId task_id
     * @return  Response
     */
    public function merge($taskId)
    {
        return $this->process(LfasrConstants::URI_MERGE, $taskId);
    }

    /**
     * 查询进度接口
     *
     * @param string $taskId task_id
     * @return  Response
     */
    public function getProgress($taskId)
    {
        return $this->process(LfasrConstants::URI_GET_PROGRESS, $taskId);
    }

    /**
     * 获取结果接口
     *
     * @param string $taskId task_id
     * @return  Response
     */
    public function getResult($taskId)
    {
        return $this->process(LfasrConstants::URI_GET_RESULT, $taskId);
    }

    /**
     * 封装操作
     *
     * @param string $task 操作
     * @param string $taskId task_id
     * @return  Response
     */
    private function process($task, $taskId)
    {
        $this->requestBody += ['task_id' => $taskId];
        return $this->client->sendAndReceive(
            new Request(
                'POST',
                $task,
                ['Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'],
                Query::build($this->requestBody)
            )
        );
    }
}
