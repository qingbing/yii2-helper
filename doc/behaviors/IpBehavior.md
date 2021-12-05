# 属性行为封装：模型中客户端IP自动填充行为
- 封装属性：ip
- 封装事件：ActiveRecord::EVENT_BEFORE_INSERT, ActiveRecord::EVENT_BEFORE_UPDATE
- 返回值：客户端IP地址

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
            IpBehavior::class,
        ];
    }
```