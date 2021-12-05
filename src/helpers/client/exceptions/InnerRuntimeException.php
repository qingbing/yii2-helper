<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client\exceptions;


use Throwable;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * 异常 : 内部系统传递运行时异常
 *
 * Class InnerRuntimeException
 * @package YiiHelper\helpers\client\exceptions
 */
class InnerRuntimeException extends InnerBadResponseException
{
    /**
     * @inheritDoc
     */
    public function __construct(Request $request, Response $response, Throwable $previous = null)
    {
        $body    = $response->getData();
        $code    = isset($body['code']) ? intval($body['code']) : null;
        $message = $body['msg'] ?? '';
        $data    = $body['data'] ?? null;
        parent::__construct($message, $code, $data, $request, $response, $previous);
    }
}