# 普通三方请求代理类: Proxy
请求其它http请求时，可直接继承该类，减少大部分发送等相关代码逻辑

- 支持属性
    - timeout: 访问超时时间
    - client: client的配置或实例
    - options: request 的选项
- 支持方法
    - setBaseUrl(string $baseUrl): 设置请求的 baseUrl
    - setOptions(array $options): 设置请求的 options
    - addOption(string $name, $value): 添加请求的 options
    - setHeaders(array $headers): 添加 client 的 headers
    - handleBeforeSend(RequestEvent $event): 重载支持 发送前句柄
    - handleAfterSend(RequestEvent $event): 重载支持 发送后句柄
    - send(string $uri, $data = null, $method = 'POST', array $files = []): 请求发送获取响应

## coding 测试
```php
// Proxy 的使用
$proxy = \Yii::createObject([
    'class'  => Proxy::class,
    'client' => [
        'baseUrl' => 'http://configure.yii.us',
    ],
]);
/* @var Proxy $proxy */
$res = $proxy->send('health', '', 'get')
    //->getContent();
    ->getData();
var_dump($res);
```