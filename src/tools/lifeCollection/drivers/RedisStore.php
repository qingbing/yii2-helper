<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\tools\lifeCollection\drivers;


use yii\di\Instance;
use yii\redis\Connection;
use YiiHelper\tools\lifeCollection\Store;

/**
 * 驱动 : redis管理生命周期数据
 *
 * Class RedisStore
 * @package YiiHelper\tools\lifeCollection\drivers
 */
class RedisStore extends Store
{
    /**
     * @var Connection
     */
    public $redis = 'redis';

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->redis = Instance::ensure($this->redis, Connection::class);
    }

    /**
     * 从头部移除有效数据
     *
     * @param int $count
     * @return bool
     */
    public function pop(int $count): bool
    {
        if ($count < 1) {
            return true;
        }
        $members = $this->getAll();
        $has     = count($members);
        if ($has < $count) {
            $count = $has;
        }
        for ($i = 0; $i < $count; $i++) {
            $this->redis->zrem($this->colName, $members[$i]);
        }
        return true;
    }

    /**
     * 获取有效数据数量
     *
     * @return int
     */
    public function getCount(): int
    {
        // 有效数据个数
        return intval($this->redis->zcount($this->colName, $this->nowTimestamp, $this->nowTimestamp + $this->expireTtl));
    }

    /**
     * 清理过期数据
     *
     * @return bool
     */
    public function clearOverdue(): bool
    {
        return false !== $this->redis->zremrangebyscore($this->colName, 0, $this->nowTimestamp);
    }

    /**
     * 新增字符串数据, 新增zdd返回1，更新score为0
     *
     * @param string $data
     * @return bool
     */
    protected function push(string $data): bool
    {
        return false !== $this->redis->zadd($this->colName, $this->nowTimestamp + $this->expireTtl, $data);
    }

    /**
     * 获取所有有效的字符串数据
     *
     * @return array
     */
    protected function getAll(): array
    {
        return $this->redis->zrangebyscore($this->colName, $this->nowTimestamp, $this->nowTimestamp + $this->expireTtl);
    }

    /**
     * 判断一个字符串数据是否有效
     *
     * @param string $data
     * @return bool
     */
    protected function isExpire(string $data): bool
    {
        return in_array($data, $this->getAll());
    }
}