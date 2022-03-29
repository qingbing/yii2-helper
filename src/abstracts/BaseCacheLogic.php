<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;

use YiiHelper\helpers\AppHelper;

/**
 * 抽象类 : 缓存逻辑基类
 *
 * Class BaseCacheLogic
 * @package YiiHelper\abstracts
 */
abstract class BaseCacheLogic extends BaseLogic
{
    /**
     * @var int 缓存有效期(秒)
     */
    protected $duration = 600;
    /**
     * @var string 缓存key
     */
    protected $key;

    /**
     * 设置缓存有效期
     *
     * @param int $duration
     * @return $this
     */
    public function setDuration(int $duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * 设置缓存key
     *
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 获取缓存键
     *
     * @return string
     */
    abstract protected function getCacheKey(): string;

    /**
     * 获取需要缓存的逻辑数据
     *
     * @return mixed
     */
    abstract protected function getCacheData();

    /**
     * 获取逻辑数据
     *
     * @return mixed
     */
    final public function getData()
    {
        return AppHelper::app()->cacheHelper->get($this->getCacheKey(), function () {
            return $this->getCacheData();
        }, $this->duration);
    }
}