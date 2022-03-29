# 属性行为封装：模型中用户账户自动填充行为
- 封装属性：nickname
- 封装事件：
    - ActiveRecord::EVENT_BEFORE_INSERT
    - ActiveRecord::EVENT_BEFORE_UPDATE
- 返回值：客户端登录用户账户

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
            AccountBehavior::class,
        ];
    }
```
