<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client;


use Exception;
use Yii;
use yii\base\BaseObject;
use yii\di\Instance;
use yii\httpclient\Request;
use yii\httpclient\RequestEvent;
use yii\httpclient\Response;

/**
 * 代理类 : 普通三方请求代理类
 *
 * Class Proxy
 * @package YiiHelper\helpers\client
 */
class Proxy extends BaseObject
{
    /**
     * @var int client 访问超时时间
     */
    public $timeout = 30;
    /**
     * @var Client | array client的配置或实例
     */
    public $client = [
        'class'              => Client::class,
        'unTranslateHeaders' => [],
    ];
    /**
     * @var array request 的选项
     */
    public $options = [];
    /**
     * @var Request
     */
    protected $request;

    /**
     * Proxy constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        if (isset($config['client']) && is_array($config['client'])) {
            $this->client = array_merge($this->client, $config['client']);
        }
        // 确保请求client是一个实例
        $this->client = Instance::ensure($this->client, Client::class);
        unset($config['client']);
        parent::__construct($config);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        // 发送请求前事件
        $this->client->on(Client::EVENT_BEFORE_SEND, [$this, 'handleBeforeSend']);
        // 发送请求后事件
        $this->client->on(Client::EVENT_AFTER_SEND, [$this, 'handleAfterSend']);
    }

    /**
     * 设置请求的 baseUrl
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->client->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * client 发送前句柄
     *
     * @param RequestEvent $event
     */
    public function handleBeforeSend(RequestEvent $event)
    {
    }

    /**
     * client 发送后句柄
     *
     * @param RequestEvent $event
     */
    public function handleAfterSend(RequestEvent $event)
    {
    }

    /**
     * 设置请求的 options
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * 添加请求的 options
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function addOption(string $name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     * 添加 client 的 headers
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->client->setHeaders($headers);
        return $this;
    }

    /**
     * URL 请求发送获取响应
     *
     * @param string $uri
     * @param mixed $data
     * @param string $method
     * @param array $files
     * @return Response
     * @throws Exception
     */
    public function send(string $uri, $data = null, $method = 'POST', array $files = [])
    {
        $request = $this->client->createRequest();
        // 获取并设置 client 超时时间
        $timeout = Yii::$app->getRequest()->getHeaders()->get("R-TIMEOUT", $this->timeout);
        $request->setOptions($this->options);
        if ($timeout > 5) {
            $request->addOptions(['timeout' => $timeout]);
        }

        if (!empty($files)) {
            $method = 'POST';
            foreach ($files as $key => $file) {
                if (is_string($file)) {
                    $request->addFile($key, $file);
                } else {
                    foreach ($file as $i => $f) {
                        $request->addFile($key . '[]', $f);
                    }
                }
            }
        }
        // 设置请求方式和uri
        $request->setMethod($method)
            ->setUrl($uri);
        // 设置请求数据
        if (is_array($data)) {
            $request->setData($data);
        } else {
            $request->setContent($data);
        }
        // 发送请求获取响应
        return $request->send();
    }
}