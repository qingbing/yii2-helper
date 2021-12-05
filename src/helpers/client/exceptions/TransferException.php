<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client\exceptions;


use RuntimeException;
use Throwable;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * 异常 : 转发异常
 *
 * Class TransferException
 * @package YiiHelper\helpers\client\exceptions
 */
class TransferException extends RuntimeException
{
    /**
     * @var Request 请求
     */
    private $_request;
    /**
     * @var Response 响应
     */
    private $_response;

    /**
     * @inheritDoc
     */
    public function __construct($message = "", $code = 0, ?Request $request = null, ?Response $response = null, ?Throwable $previous = null)
    {
        if (is_array($message) || is_object($message)) {
            $message = var_export($message, true);
        } else {
            $message = strval($message);
        }
        $this->_request  = $request;
        $this->_response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * 获取请求组件
     *
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * 获取响应组件
     *
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * 检查是否接收到响应
     *
     * @return bool
     */
    public function hasResponse()
    {
        return null !== $this->_response;
    }
}