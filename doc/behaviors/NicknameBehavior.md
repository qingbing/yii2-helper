# 属性行为封装：模型中登录用户昵称自动填充行为
- 封装属性：nickname
- 封装事件：ActiveRecord::EVENT_BEFORE_INSERT
- 返回值：客户端登录用户昵称

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
            NicknameBehavior::class,
        ];
    }
```
