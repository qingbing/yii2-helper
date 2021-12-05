# 属性行为封装：web请求的附加行为
- 行为：为 web-request 请求附加行为方法
- 行为附加方法
    - getShortContentType() : 获取请求的内容方法
    - isFormData() : 判断是否是 form-data， form-data 表示可以上传文件
    - getParams() : 获取所有请求参数
    - getParam(string $name, $default = null) : 获取传递参数的值

## coding 示例

```php
'components'    => [
    'request'        => [
        'as requestBehavior'   => \YiiHelper\behaviors\RequestBehavior::class,
    ],
],
```
