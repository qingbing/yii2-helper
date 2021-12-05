# 组件 ErrorHandler ： 重构错误控制句柄
- 继承自 \yii\web\ErrorHandler

## coding 使用
```php
'components' => [
    'errorHandler'   => [
        'class' => \YiiHelper\components\ErrorHandler::class,
    ],
],
```