#组件类 CacheHelper ：缓存助手

# coding 使用
- 设置一个缓存 : set($key, $value, $duration = null, $dependency = null)
- 删除一个缓存 : delete($key)
- 获取一个缓存，如果不存在就通过 $callback 设置一个 : get($key, ?callable $callback, ?int $duration = null)

## 1.配置组件

```php
'components'       => [
    'cacheHelper'  => [
        'class'     => CacheHelper::class,
        // 是否获取真实的缓存，为false时，所有缓存获取都为false
        'openCache' => false,
        // 缓存使用的组件id
        'cacheId'   => 'cache',
    ],
],
```

## 2. 调用方式

```php
Yii::$app->cacheHelper->set($key, $value, $duration = null, $dependency = null)
Yii::$app->cacheHelper->delete($key)
Yii::$app->cacheHelper->get($key, ?callable $callback, ?int $duration = null)
```
