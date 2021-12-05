<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers;


use Zf\Helper\Abstracts\Singleton;
use Zf\Helper\Format;
use Zf\Helper\ReqHelper;

/**
 * 页面响应数据
 *
 * Class Response
 * @package YiiHelper\helpers
 */
class Response extends Singleton
{
    /**
     * @var int 响应码
     */
    private $_code = 0;
    /**
     * @var string 响应消息
     */
    private $_msg = "ok";

    /**
     * 设置 响应码
     *
     * @param int $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }

    /**
     * 设置 响应消息
     *
     * @param string|null $msg
     * @return $this
     */
    public function setMsg(?string $msg)
    {
        $this->_msg = $msg;
        return $this;
    }

    /**
     * 获取最终返回响应
     *
     * @param mixed $data
     * @return array
     * @throws \Exception
     */
    public function output($data = null)
    {
        return [
            'time'     => Format::microDatetime(),
            'code'     => $this->_code,
            'msg'      => $this->_msg,
            'data'     => $data,
            'trace_id' => ReqHelper::getTraceId()
        ];
    }

    /**
     * 成功响应
     *
     * @param mixed $data
     * @param string|null $msg
     * @return array
     * @throws \Exception
     */
    public function success($data = null, ?string $msg = 'ok')
    {
        $this->setCode(0);
        $this->setMsg($msg);
        return $this->output($data);
    }

    /**
     * 失败响应
     *
     * @param int $code
     * @param string|null $msg
     * @param mixed $data
     * @return array
     * @throws \Exception
     */
    public function fail(int $code = -1, ?string $msg = 'ok', $data = null)
    {
        $this->setCode($code);
        $this->setMsg($msg);
        return $this->output($data);
    }
}