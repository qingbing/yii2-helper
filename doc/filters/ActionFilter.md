# 过滤器 ActionFilter ： Action过滤器
- 可配置属性
    - beforeActionCallback ： beforeAction 前需要执行的回调函数
    - afterActionCallback ： afterAction 前需要执行的回调函数


##  使用方法，在控制器中配置

```php

    /**
     * 定义行为
     *
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'actionCallback' => [
                'class' => ActionFilter::class,
                'only'  => ['index'],
                // 指定 beforeAction 回调
                'beforeActionCallback' => [
                    [$this, 'beforeIndex'],
                ],
                // 指定 afterAction 回调
                'afterActionCallback'  => [$this, 'afterIndex'],
            ]
        ]);
    }
```
