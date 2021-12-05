# 属性行为封装：默认值填充
- 返回值：为空时的默认值
- 定义属性
    - type ： 支持默认值的类型，目前只支持 date, 和 datetime
    - strict ： 是否严格判断是否为空

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
            [
                'class'      => DefaultBehavior::class,
                'type'       => DefaultBehavior::TYPE_DATE,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['birthday'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['birthday'],
                ],
            ],
            [
                'class'      => DefaultBehavior::class,
                'type'       => DefaultBehavior::TYPE_DATETIME,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['expire_begin_date', 'expire_end_date', 'last_login_at',],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['expire_begin_date', 'expire_end_date', 'last_login_at',],
                ],
            ],
        ];
    }
```
