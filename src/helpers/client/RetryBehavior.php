<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client;


use yii\base\Behavior;
use yii\base\Component;

/**
 * 行为 : 记录重试次数
 *
 * Class RetryBehavior
 * @package YiiHelper\helpers\client
 */
class RetryBehavior extends Behavior
{
    /**
     * @var int 重试次数
     */
    private $_retry = 0;

    /**
     * 获取重试次数
     *
     * @return int
     */
    public function getRetry(): int
    {
        return $this->_retry;
    }

    /**
     * 设置重试次数
     *
     * @param int $retry
     * @return Component
     */
    public function setRetry(int $retry)
    {
        $this->_retry = $retry;
        return $this->owner;
    }
}