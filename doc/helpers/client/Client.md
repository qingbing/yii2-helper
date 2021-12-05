# 客户端请求封装 : Client
- 继承自 \yii\httpclient\Client
- 增加属性
    - translateHeaderPrefix: string, 透传的 header 前缀
    - translateHeaders: array, 透传的 header 名
    - unTranslateHeaders: array, 不透传的 header 名
    - openFileLog: bool, 是否开启文件日志
    - openDbLog: bool, 是否开启db日志
    - systemCode: string, 请求系统代码
    - retry: int, 请求失败重试次数
    - noResponseErrorCode: int, 请求无 response 时的自定义响应代码
    - dbLogModelClass: string, db日志模型名
- 增加方法
    - setHeaders(array $headers): 添加 headers
    - setHeader(string $name, $value): 添加一个header
    - createRequest(): 创建请求
    - send($request): 发送请求并获取响应
    - beforeSend($request): 发送请求前回调
    - handleDbLog(RequestEvent $event): db-log 开始时日志入库处理


## coding 代码示例
```php
// Client 的使用
$client = \Yii::createObject([
    'class'   => Client::class,
    'baseUrl' => 'http://configure.yii.us',
]);
/* @var Client $client */
$response = $client->createRequest()
    ->setUrl('/health')
    ->setMethod('post')
    ->setData('good')
    ->send();
var_dump($response->getData());
```
