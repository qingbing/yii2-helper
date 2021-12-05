# 内部系统请求客户端 : InnerClient
- 继承自 YiiHelper\helpers\client\Client
- 增加属性
    - translateHeaderPrefix: string, 透传的 header 前缀，默认指定为"x-"
    - unTranslateHeaders: array, 不透传的 header 名，默认指定为 ['x-system','x-from-system','x-trace-id']
- 重载方法
    - init: 实例初始化
    - beforeSend($request): 发送请求前回调
