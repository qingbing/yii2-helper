<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\components;


use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\CacheInterface;
use yii\di\Instance;

/**
 * 组件类：缓存助手
 *
 * Class CacheHelper
 * @package YiiHelper\components
 */
class CacheHelper extends Component
{
    /**
     * @var bool 是否获取真实的缓存，为false时，所有缓存获取都为false
     */
    public $openCache = true;
    /**
     * @var CacheInterface
     */
    protected $cache = 'cache';

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->cache = Instance::ensure($this->cache, CacheInterface::class);
    }

    /**
     * 设置一个缓存
     *
     * @param mixed $key
     * @param mixed $value
     * @param null $duration
     * @param null $dependency
     * @return bool
     */
    public function set($key, $value, $duration = null, $dependency = null)
    {
        return $this->cache->set($key, $value, $duration, $dependency);
    }

    /**
     * 删除一个缓存
     *
     * @param mixed $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->cache->delete($key);
    }

    /**
     * 获取一个缓存，如果不存在就通过 $callback 设置一个
     *
     * @param mixed $key
     * @param callable|null $callback
     * @param int|null $duration
     * @param null $dependency
     * @return bool|mixed
     */
    public function get($key, ?callable $callback = null, ?int $duration = null, $dependency = null)
    {
        if (!is_callable($callback)) {
            // 常规的缓存获取
            if ($this->openCache) {
                return $this->cache->get($key);
            }
        } elseif ($this->openCache) {
            // 打开缓存的回写式
            if (false === ($output = $this->cache->get($key))) {
                // 重新获取数据并设置缓存
                $output = call_user_func($callback);
                $this->cache->set($key, $output, $duration, $dependency);
            }
            return $output;
        } else {
            // 未开缓存的回写式
            $output = call_user_func($callback);
            $this->cache->set($key, $output, $duration, $dependency);
            return $output;
        }
        return false;
    }
}