# 属性行为封装：模型中客户端日志ID自动填充行为
- 封装属性：trace_id
- 封装事件：ActiveRecord::EVENT_BEFORE_INSERT
- 返回值：客户端请求的链路ID

## coding 示例

```php
    /**
     * 绑定 behavior
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TraceIdBehavior::class
        ];
    }
```
