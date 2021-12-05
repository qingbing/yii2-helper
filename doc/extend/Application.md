# yii扩展类 ： Application

- 扩展 \yii\web\Application
- 添加属性
    - transmitRoute ： 中转传输路由，默认"transmit/index"
    - defaultSystem ： 系统，默认"portal"
- 增加方法
    - getSystemAlias() ： 获取当前请求的系统标记，系统标识放在header中"x-system"


# coding 使用

```php
# 修改 /web/index.php（网页入口文件）， 使用 该应用来启动项目

(new \YiiHelper\extend\Application($config))->run();
```
