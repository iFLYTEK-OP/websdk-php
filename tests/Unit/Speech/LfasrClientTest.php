<?php

namespace IFlytek\Xfyun\Speech\Tests\Unit\Speech;

use IFlytek\Xfyun\Speech\LfasrClient;
use IFlytek\Xfyun\Core\Traits\JsonTrait;
use Symfony\Component\Yaml\Yaml;

class LfasrClientTest extends BaseClientTest
{
    use JsonTrait;

    /** @var LfasrClient */
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->ability = 'lfasr';
    }

    public function setUp()
    {
        parent::setUp();
        $this->client = new LfasrClient($this->config['appId'], $this->config['secretKey']);
    }

    public function testSuccessfullyPrepare()
    {
        $this->assertInstanceOf(LfasrClient::class, $this->client);
        $response = $this->client->prepare(__DIR__ . '/../../input/1.wav');
        $this->assertEquals(200, $response->getStatusCode());
        $result = $this->jsonDecode($response->getBody()->getContents(), true);
        putenv('PHPSDK_SPEECH_LFASR_TASKID=' . $result['data']);
        $this->assertEquals(0, $result['err_no']);
    }

    public function testSuccessfullyUpload()
    {
        $this->assertEquals(200, $this->client->upload($this->config['taskId'], __DIR__ . '/../../input/1.wav')->getStatusCode());
    }

    public function testSuccessfullyMerge()
    {
        $this->assertEquals(200, $this->client->merge($this->config['taskId'])->getStatusCode());
    }

    public function testSuccessfullyGetProgress()
    {
        $response = $this->client->getProgress($this->config['taskId']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(200, $this->client->getProgress($this->config['taskId'])->getStatusCode());
    }

    public function testSuccessfullyGetResult()
    {
        $response = $this->client->getResult($this->config['taskId']);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(200, $this->client->getProgress($this->config['taskId'])->getStatusCode());
    }

    public function testSuccessfullyCombileUpload()
    {
        $taskId = $this->client->combineUpload(__DIR__ . '/../../input/1.wav');
        $this->assertNotNull($taskId);
        if (file_exists($credentialsFile = __DIR__ . '/../credentials.yml')) {
            $credentials = Yaml::parseFile($credentialsFile);
            $credentials['lfasr']['taskId'] = $taskId;
            file_put_contents($credentialsFile, Yaml::dump($credentials));
        }
    }
}
