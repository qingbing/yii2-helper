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
 * 异常 : 内部系统传递响应格式异常
 *
 * Class InnerFormatException
 * @package YiiHelper\helpers\client\exceptions
 */
class InnerFormatException extends InnerBadResponseException
{
    /**
     * @inheritDoc
     */
    public function __construct(Request $request, Response $response, Throwable $previous = null)
    {
        parent::__construct('响应不能解析为数组', 0, $response->getData(), $request, $response, $previous);
    }
}