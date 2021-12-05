<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client\exceptions;


use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * 异常 : 系统传递响应异常
 *
 * Class BadResponseException
 * @package YiiHelper\helpers\client\exceptions
 */
class BadResponseException extends RequestException
{
    /**
     * @inheritDoc
     */
    public function __construct($message, Request $request, Response $response, \Exception $previous = null)
    {
        parent::__construct($message, $request, $response, $previous);
    }
}