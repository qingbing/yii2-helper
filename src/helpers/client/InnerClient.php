<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client;


use Exception;
use Yii;
use yii\httpclient\Request;
use yii\web\UrlNormalizerRedirectException;
use YiiHelper\helpers\client\exceptions\InnerBadResponseException;
use YiiHelper\helpers\client\exceptions\InnerFormatException;
use YiiHelper\helpers\client\exceptions\InnerRuntimeException;
use Zf\Helper\ReqHelper;

/**
 * 组件 : 内部系统请求客户端
 *
 * Class InnerClient
 * @package YiiHelper\helpers\client
 */
class InnerClient extends Client
{
    /**
     * @var string 透传的 header 前缀
     */
    public $translateHeaderPrefix = 'x-';
    /**
     * @var array 不透传的 header 名
     */
    public $unTranslateHeaders = [
        'x-system', // 组件自处理
        'x-from-system', // 组件自处理
        'x-trace-id', // 组件自处理
    ];

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->setHeader('x-from-system', Yii::$app->id)
            ->setHeader('x-trace-id', ReqHelper::getTraceId());
    }

    /**
     * @inheritDoc
     * 发送请求前回调
     *
     * @param Request $request
     */
    public function beforeSend($request)
    {
        parent::beforeSend($request);
        $this->setHeader('x-system', $this->systemCode);
    }

    /**
     * @param Request $request
     * @return mixed|void
     * @throws UrlNormalizerRedirectException
     * @throws Exception
     */
    public function send($request)
    {
        try {
            $response = parent::send($request);
            if (intval($response->getStatusCode()) == 302) {
                throw new UrlNormalizerRedirectException($response->headers->get('Location') ?? '');
            }
            $body = $response->getData();
            if (!is_array($body)) {
                throw new InnerFormatException($request, $response);
            }
            $code = isset($body['code']) ? intval($body['code']) : null;
            $data = $body['data'] ?? null;
            if ($code === null || $code !== 0) {
                throw new InnerRuntimeException($request, $response);
            }
            return $data;
        }
        catch (InnerBadResponseException $exception) {
            $this->catchException($request, $exception);
        }
    }
}