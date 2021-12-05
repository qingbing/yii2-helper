<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\traits;

use YiiHelper\helpers\Response;

/**
 * 响应处理片段
 *
 * Trait TResponse
 * @package YiiHelper\helpers
 */
trait TResponse
{
    /**
     * 获取响应处理类
     *
     * @return Response
     */
    public function getResponse()
    {
        return Response::getInstance();
    }

    /**
     * 成功响应
     *
     * @param mixed $data
     * @param string|null $msg
     * @return array
     * @throws \Exception
     */
    public function success($data = null, ?string $msg = '操作成功')
    {
        return $this->getResponse()->success($data, $msg);
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
    public function fail(int $code = -1, ?string $msg = '操作失败', $data = null)
    {
        return $this->getResponse()->fail($code, $msg, $data);
    }
}