<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client;


use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\httpclient\CurlTransport;
use yii\httpclient\Request;
use yii\httpclient\RequestEvent;
use yii\httpclient\Response;
use yii\web\HeaderCollection;
use YiiHelper\helpers\client\exceptions\RequestException;
use YiiHelper\models\ClientLogs;
use Zf\Helper\Format;

/**
 * 组件 : 请求客户端
 *
 * Class Client
 * @package YiiHelper\helpers\client
 */
class Client extends \yii\httpclient\Client
{
    /**
     * @var string 透传的 header 前缀
     */
    public $translateHeaderPrefix;
    /**
     * @var array 透传的 header 名
     */
    public $translateHeaders = [];
    /**
     * @var array 不透传的 header 名
     */
    public $unTranslateHeaders = [];
    /**
     * @var bool 是否开启文件日志
     */
    public $openFileLog = true;
    /**
     * @var bool 是否开启db日志
     */
    public $openDbLog = true;
    /**
     * @var string 请求系统代码
     */
    public $systemCode = '';
    /**
     * @var int 请求失败重试次数
     */
    public $retry = 0;
    /**
     * @var int 请求无 response 时的自定义响应代码
     */
    public $noResponseErrorCode = 0;
    /**
     * @var string db日志模型名
     */
    public $dbLogModelClass = ClientLogs::class;

    protected $beginTime;
    protected $noResponseErrorMsg;
    /**
     * @var HeaderCollection
     */
    protected $headers;

    /**
     * @inheritDoc
     */
    public function __construct($config = [])
    {
        $this->headers = new HeaderCollection();
        if (!isset($config['transport'])) {
            $config['transport'] = CurlTransport::class;
        }
        parent::__construct($config);
        $this->translateHeader();
    }

    /**
     * header 透传处理
     */
    protected function translateHeader()
    {
        if (!$this->translateHeaderPrefix && count($this->translateHeaders) === 0) {
            return;
        }
        $headerCollection = Yii::$app->getRequest()->getHeaders();
        foreach ($headerCollection->toArray() as $name => $_) {
            if (in_array($name, $this->unTranslateHeaders)) {
                continue;
            }
            if (in_array($name, $this->translateHeaders)) {
                $this->headers->add($name, $headerCollection->get($name));
                continue;
            }
            if ($this->translateHeaderPrefix && 0 === strpos($name, $this->translateHeaderPrefix)) {
                $this->headers->add($name, $headerCollection->get($name));
            }
        }
    }

    /**
     * 添加 headers
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }
        return $this;
    }

    /**
     * 添加一个header
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setHeader(string $name, $value)
    {
        $this->headers->set($name, $value);
        return $this;
    }

    /**
     * 创建请求
     *
     * @return Request
     * @throws InvalidConfigException
     */
    public function createRequest()
    {
        $request = parent::createRequest();
        $request->attachBehavior('retry', RetryBehavior::class);
        if ($this->retry > 0) {
            $request->setRetry($this->retry);
        }
        if ($this->openDbLog) {
            $this->on(self::EVENT_AFTER_SEND, [$this, 'handleDbLog']);
        }
        return $request;
    }

    /**
     * 发送请求并获取响应
     *
     * @param Request $request
     * @return Response | void
     * @throws Exception
     */
    public function send($request)
    {
        $this->beginTime = microtime(true);
        try {
            $request->setHeaders($this->headers);
            $response = parent::send($request);
            $code     = $response->getStatusCode();
            if ($code === null || intval($code) >= 400) {
                throw RequestException::create($request, $response);
            }

            if ($this->openFileLog) {
                $this->fileLogForAccess($request, $response);
            }
            return $response;
        }
        catch (Exception $exception) {
            $this->catchException($request, $exception);
        }
    }

    /**
     * 异常处理
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response
     * @throws Exception
     */
    protected function catchException(Request $request, Exception $exception)
    {
        $retry = $request->getRetry();
        if ($retry > 0) {
            $request->setRetry(--$retry);
            return $this->send($request);
        }
        // 异常日志文件
        $this->fileLogForError($request, $exception);

        if (!isset($response)) {
            $this->noResponseErrorMsg = $exception->getMessage();
        }
        $this->afterSend($request, $response ?? null);
        throw $exception;
    }

    /**
     * @inheritDoc
     * 发送请求前回调
     *
     * @param Request $request
     */
    public function beforeSend($request)
    {
        parent::beforeSend($request); // TODO: Change the autogenerated stub
        $this->headers->remove('content-length');
    }

    /**
     * db-log 开始时日志入库处理
     *
     * @param RequestEvent $event
     * @throws Exception
     */
    public function handleDbLog(RequestEvent $event)
    {
        $dbData   = [
            'system_code'        => Yii::$app->id,
            'called_system_code' => $this->systemCode,
            'full_url'           => $event->request->getFullUrl(),
            'method'             => $event->request->getMethod(),
            'request_time'       => Format::datetime($this->beginTime),
            'request_data'       => [
                'header' => $event->request->headers->toArray(),
                'data'   => $event->request->getData(),
                'file'   => $_FILES,
            ],
            'use_time'           => microtime(true) - $this->beginTime,
        ];
        $response = $event->response;
        if (null === $response) {
            $dbData['response_code'] = $this->noResponseErrorCode;
            $dbData['response_data'] = $this->noResponseErrorMsg;
        } else {
            $dbData['response_code'] = $response->getStatusCode();
            $dbData['response_data'] = $response->getData();
        }
        $model = Yii::createObject($this->dbLogModelClass);
        $model->setAttributes($dbData);
        $model->saveOrException();
    }

    /**
     * 访问文件日志
     *
     * @param Request $request
     * @param Response $response
     * @throws \yii\httpclient\Exception
     */
    protected function fileLogForAccess(Request $request, Response $response)
    {
        $logData = [
            'method'   => $request->getMethod(),
            'full_url' => $request->getFullUrl(),
            'req_data' => [
                'header' => $request->headers->toArray(),
                'data'   => $request->getData(),
                'file'   => $_FILES,
            ],
            'res_data' => [
                'use_time' => microtime(true) - $this->beginTime,
                'code'     => $response->getStatusCode(),
                'data'     => $response->getData(),
            ]
        ];
        Yii::info(json_encode($logData, JSON_UNESCAPED_UNICODE), "client.access");
    }

    /**
     * 异常日志文件
     *
     * @param Request $request
     * @param Exception $exception
     */
    protected function fileLogForError(Request $request, Exception $exception)
    {
        $logData = [
            'method'   => $request->getMethod(),
            'full_url' => $request->getFullUrl(),
            'req_data' => [
                'header' => $request->headers->toArray(),
                'data'   => $request->getData(),
                'file'   => $_FILES,
            ],
            'res_data' => [
                'use_time' => microtime(true) - $this->beginTime,
                'code'     => $exception->getCode(),
                'message'  => $exception->getMessage(),
            ]
        ];
        Yii::error(json_encode($logData, JSON_UNESCAPED_UNICODE), "client.error");
    }
}