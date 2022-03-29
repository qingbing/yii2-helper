# 抽象类 : 缓存逻辑基类 (\YiiHelper\abstracts\BaseCacheLogic)
- 继承自 \YiiHelper\abstracts\BaseLogic
- 对外提供方法
    - setParams(array $params) : 设置逻辑参数
    - setDuration(int $duration) : setDuration(int $duration)
    - setKey($key) : 设置缓存key
    - public function getData() : 获取逻辑数据
    - abstract protected function getCacheKey(): 获取缓存键
    - abstract protected function getCacheData(): 获取需要缓存的逻辑数据


## 使用示例
```php

class demo extends \YiiHelper\abstracts\BaseCacheLogic
{
    /**
     * 获取缓存键
     *
     * @return string
     */
    protected function getCacheKey(): string
    {
        return 'custom_cache_key';
    }

    /**
     * 获取需要缓存的逻辑数据
     *
     * @return mixed
     */
    protected function getCacheData()
    {
        return $this->params;
    }
}

$data = demo::getInstance()
    ->setParams([
        'test' => "test-params",
    ])
    ->getData();
var_dump($data);

```
