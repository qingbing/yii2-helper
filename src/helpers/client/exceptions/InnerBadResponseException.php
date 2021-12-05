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
 * 异常 : 内部系统传递响应异常
 *
 * Class InnerBadResponseException
 * @package YiiHelper\helpers\client\exceptions
 */
class InnerBadResponseException extends TransferException
{
    /**
     * @var array
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function __construct($message = "", $code = 0, $data = null, Request $request = null, Response $response = null, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $request, $response, $previous);
    }

    /**
     * @return null|array
     */
    public function getData()
    {
        return $this->data;
    }
}