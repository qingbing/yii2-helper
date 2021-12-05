# 工具 : redis 计数器
- 提供属性
    - redis: redis组件ID或redis数组配置
- 提供的方法
    - setTtl(string $key, int $second): 设置 key 的过期时间
    - setExpireAt(string $key, int $timestamp): 设置 key 的过期时间戳
    - get(string $key): 获取计数器
    - incr(string $key, $increment = 1): 计数器增加
    - decr(string $key, $increment = 1): 计数器减少
    - zero(string $key): 计数器清零
    - flush(string $key): 清除计数器

# coding 示例
```php
$counter = \Yii::createObject([
    'class' => RedisCounter::class,
]);
/* @var RedisCounter $counter */
//
$key = "redis:counter:test";
// 设置 key 的过期时间
$counter->setTtl($key, 10);
// 设置 key 的过期时间戳
$counter->setExpireAt($key, time() + 10);
// 计数器增加
$counter->incr($key, 1);
// 计数器减少
$counter->decr($key, 1);
// 获取计数器
var_dump($counter->get($key));
// 计数器清零
$counter->zero($key);
// 清除计数器
$counter->flush($key);
```
