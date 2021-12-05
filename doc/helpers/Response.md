# 响应类 Response

- 继承单例 Singleton
- 可用方法
    - 设置 响应码 ： setCode(int $code)
    - 设置 响应消息 ： setMsg(?string $msg)
    - 获取最终返回响应 ： output($data = null)
    - 成功响应 ： success($data = null, ?string $msg = 'ok')
    - 失败响应 ： fail(int $code = -1, ?string $msg = 'ok', $data = null)

## test 代码

```php
// 设置 响应码
Response::getInstance()->setCode(0);
// 设置 响应消息
Response::getInstance()->setMsg('ok);
// 获取最终返回响应
Response::getInstance()->output(null);
// 成功响应
Response::getInstance()->success(null, ok);
// 失败响应
Response::getInstance()->fail(-1, 'ok', null);
```
