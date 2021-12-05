<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\tools;


use yii\base\Component;
use yii\di\Instance;
use yii\redis\Connection;

/**
 * 工具 : redis 计数器
 *
 * Class RedisCounter
 * @package YiiHelper\tools
 */
class RedisCounter extends Component
{
    /**
     * @var Connection redis组件ID或redis数组配置
     */
    public $redis;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->redis = Instance::ensure($this->redis, Connection::class);
    }

    /**
     * 设置 key 的过期时间
     *
     * @param string $key
     * @param int $second 有效的时间，单位秒
     * @return mixed
     */
    public function setTtl(string $key, int $second)
    {
        return $this->redis->expire($key, $second);
    }

    /**
     * 设置 key 的过期时间戳
     *
     * @param string $key
     * @param int $timestamp 有效的时间戳
     * @return mixed
     */
    public function setExpireAt(string $key, int $timestamp)
    {
        return $this->redis->expireat($key, $timestamp);
    }

    /**
     * 获取计数器
     *
     * @param string $key
     * @return int
     */
    public function get(string $key): int
    {
        return intval($this->redis->get($key));
    }

    /**
     * 计数器增加
     *
     * @param string $key
     * @param int $increment
     * @return int
     */
    public function incr(string $key, $increment = 1): int
    {
        return intval($this->redis->incrby($key, $increment));
    }

    /**
     * 计数器减少
     *
     * @param string $key
     * @param int $increment
     * @return int
     */
    public function decr(string $key, $increment = 1): int
    {
        return intval($this->redis->decrby($key, $increment));
    }

    /**
     * 计数器清零
     *
     * @param string $key
     * @return mixed
     */
    public function zero(string $key)
    {
        return $this->redis->set($key, 0);
    }

    /**
     * 清除计数器
     *
     * @param string $key
     * @return mixed
     */
    public function flush(string $key)
    {
        return $this->redis->del($key);
    }
}