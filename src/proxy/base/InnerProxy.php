<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\proxy\base;


use Exception;
use Yii;
use yii\caching\CacheInterface;
use yii\di\Instance;
use yii\httpclient\Response;
use YiiHelper\helpers\client\Client;
use YiiHelper\helpers\client\InnerClient;
use YiiHelper\helpers\client\Proxy;
use YiiHelper\helpers\Req;
use Zf\Helper\Crypt\Openssl;
use Zf\Helper\Exceptions\ProgramException;

/**
 * Class InnerProxy
 * @package YiiHelper\proxy\base
 *
 * @property string $baseUrl 访问系统的host
 * @property string $systemCode 系统代码
 */
abstract class InnerProxy extends Proxy
{
    /**
     * @var bool 是否开启token验证
     */
    public $enableToken = false;
    /**
     * @var string 请求访问 UUID
     */
    public $uuid;
    /**
     * @var string 加密 token 时需要的 openssl_public_key
     */
    public $publicKey;
    /**
     * @var int 接受服务区url的有效时间
     */
    public $urlExpireTtl = 120;
    /**
     * @var string 开启token 时获取 token 的url
     */
    public $tokenUrl = 'inner/oauth/token';
    /**
     * @var CacheInterface
     */
    public $cache = 'cache';
    /**
     * @var Client | array client的配置或实例
     */
    public $client = [
        'class'                 => InnerClient::class,
        'translateHeaderPrefix' => 'x-',
        'unTranslateHeaders'    => [
            'x-system', // InnerClient 中处理
            'x-from-system', // InnerClient 中处理
            'x-trace-id', // InnerClient 中处理
            'x-access-uuid', // 组件自处理
            'x-access-token', // 组件自处理
        ],
    ];
    /**
     * @var string 访问系统的host
     */
    private $_baseUrl;
    /**
     * @var string 访问系统代码
     */
    private $_systemCode;

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        // 确保缓存组件
        $this->cache = Instance::ensure($this->cache, CacheInterface::class);
        if (!empty($this->baseUrl)) {
            $this->client->baseUrl = $this->baseUrl;
        }
        // 添加透传的 header
        $this->client->setHeaders([
            'x-forwarded-for'   => Req::getUserIp(),
            'x-portal-is-guest' => Req::getIsGuest(),
            'x-portal-is-super' => Req::getIsSuper(),
            'x-portal-uid'      => Req::getUid(),
        ]);
    }

    /**
     * 获取访问系统代码
     *
     * @return string
     */
    public function getSystemCode(): string
    {
        return $this->_systemCode;
    }

    /**
     * 设置访问系统代码
     *
     * @param string $systemCode
     * @return $this
     * @throws ProgramException
     */
    public function setSystemCode(string $systemCode)
    {
        if (empty($systemCode)) {
            throw new ProgramException("代理设置的「systemCode」不能为空");
        }
        $this->_systemCode = $this->client->systemCode = $systemCode;
        return $this;
    }

    /**
     * 获取访问系统 baseUrl
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->_baseUrl;
    }

    /**
     * 设置访问系统 baseUrl
     *
     * @param string $baseUrl
     * @return $this
     * @throws ProgramException
     */
    public function setBaseUrl(string $baseUrl)
    {
        if (empty($baseUrl)) {
            throw new ProgramException("代理设置的「baseUrl」不能为空");
        }
        $this->_baseUrl = $this->client->baseUrl = $baseUrl;
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
        $this->client->setHeader('x-access-uuid', $this->uuid);
        // 添加访问token
        if ($this->enableToken) {
            $this->client->setHeader('x-access-token', $this->getToken());
        }
        return parent::send($uri, $data, $method, $files);
    }

    /**
     * 获取系统访问 token
     *
     * @return mixed
     * @throws Exception
     */
    protected function getToken()
    {
        $cacheKey = "client:innerProxy:token:" . Yii::$app->id . ":{$this->systemCode}:{$this->uuid}";
        if (false === ($token = $this->cache->get($cacheKey))) {
            $this->client->setHeader('x-access-uuid', $this->uuid);
            $data  = parent::send($this->tokenUrl, [
                'sign' => Openssl::encrypt($this->publicKey, [
                    'timestamp'    => time(),
                    'urlExpireTtl' => $this->urlExpireTtl,
                ]),
            ]);
            $token = $data['token'];
            $this->cache->set($cacheKey, $token, $data['expireTtl'] - 300);
        }
        return $token;
    }

    /**
     * 健康检查
     *
     * @return Response
     * @throws Exception
     */
    public function health()
    {
        return $this->send('health');
    }
}