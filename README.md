# yii-helper
## 版本控制
- 1.0.1 常用的基础类库整理

## 描述
yii 公用的一些基础类库

### 抽象类
1. [基本的队列任务封装 : BaseQueueJob](doc/abstracts/BaseQueueJob.md)
1. [控制台基类 : ConsoleController](doc/abstracts/ConsoleController.md)
1. [db-model基类 : Model](doc/abstracts/Model.md)
1. [控制器基类 : RestController](doc/abstracts/RestController.md)
1. [服务基类 : Service](doc/abstracts/Service.md)
1. [超管服务基类 : SuperService](doc/abstracts/SuperService.md)


### 封装行为
1. [默认值填充 : DefaultBehavior](doc/behaviors/DefaultBehavior.md)
1. [模型中客户端IP自动填充行为 : IpBehavior](doc/behaviors/IpBehavior.md)
1. [模型中登录用户昵称自动填充行为 : NicknameBehavior](doc/behaviors/NicknameBehavior.md)
1. [web请求的附加行为 : RequestBehavior](doc/behaviors/RequestBehavior.md)
1. [模型中客户端日志ID自动填充行为 : TraceIdBehavior](doc/behaviors/TraceIdBehavior.md)
1. [模型中用户ID自动填充行为 : UidBehavior](doc/behaviors/UidBehavior.md)


### 组件封装
1. [缓存助手 : CacheHelper](doc/components/CacheHelper.md)
1. [重构错误控制句柄 : ErrorHandler](doc/components/ErrorHandler.md)


### 控制器
1. [健康状态控制器 : HealthController](doc/controllers/HealthController.md)


### yii扩展类
1. [yii扩展类 : Application](doc/extend/Application.md)
1. [文件日志持久化 : FileTarget](doc/extend/FileTarget.md)


### 过滤器
1. [Action过滤器 : ActionFilter](doc/filters/ActionFilter.md)


### 服务接口
1. [CURD(增删改查)服务接口 : ICurdService](doc/services/interfaces/ICurdService.md)
1. [服务基类 : IService](doc/services/interfaces/IService.md)


### 助手类器
1. [Yii-App 辅助类 : AppHelper](doc/helpers/AppHelper.md)
1. [动态数据验证模型 : DynamicModel](doc/helpers/DynamicModel.md)
1. [响应类 : Response](doc/helpers/Response.md)
1. [请求助手 : Req](doc/helpers/Req.md)
1. [数据分页类 : Pager](doc/helpers/Pager.md)
1. client请求类
    - [客户端请求封装 : Client](doc/helpers/client/Client.md)
    - [内部系统请求客户端 : InnerClient](doc/helpers/client/InnerClient.md)
    - [普通三方请求代理类 : Proxy](doc/helpers/client/Proxy.md)
    - [为实例附加重试计算功能 : RetryBehavior](doc/helpers/client/RetryBehavior.md)
    - [抽象类，系统代理 : SystemProxy](doc/helpers/client/SystemProxy.md)


### 逻辑类
1. [配置的 key-value 的获取 : KeyValues](doc/logic/KeyValues.md)


### 工具
1. [redis 计数器 : RedisCounter](doc/tools/RedisCounter.md)
1. [生命周期集合管理 : LifeCollection](doc/tools/lifeCollection/LifeCollection.md)
    1. [生命周期数据管理 : Store](doc/tools/lifeCollection/Store.md)
        1. [db管理生命周期数据 : DbStore](doc/tools/lifeCollection/drivers/DbStore.md)
        1. [redis管理生命周期数据 : RedisStore](doc/tools/lifeCollection/drivers/RedisStore.md)


### 片段
1. [用户登录状态判断 : TLoginRequired](doc/traits/TLoginRequired.md)
1. [yii\db\Query的扩展处理 : TQueryWhere](doc/traits/TQueryWhere.md)
1. [响应处理片段 : Response](doc/traits/TResponse.md)
1. [制作保存失败抛出异常片段 : TSave](doc/traits/TSave.md)
1. [数据验证片段 : TValidator](doc/traits/TValidator.md)


### 自定义常用验证类型
1. [yii-validator扩展验证数据是否是联系方式(手机或座机) : ContactValidator](doc/validators/ContactValidator.md)
1. [yii-validator扩展验证数据是否是传真号码 : FaxValidator](doc/validators/FaxValidator.md)
1. [yii-validator扩展验证数据是否是身份证号码 : IdCardValidator](doc/validators/IdCardValidator.md)
1. [yii-validator扩展验证数据类型为json字符串 : JsonValidator](doc/validators/JsonValidator.md)
1. [yii-validator扩展验证数据是否是手机号码 : MobileValidator](doc/validators/MobileValidator.md)
1. [yii-validator扩展验证数据是否是姓名 : NameValidator](doc/validators/NameValidator.md)
1. [yii-validator扩展验证数据是否是密码格式 : PasswordValidator](doc/validators/PasswordValidator.md)
1. [yii-validator扩展验证数据是否是座机号码 : PhoneValidator](doc/validators/PhoneValidator.md)
1. [yii-validator扩展验证数据是否是qq号码 : QqValidator](doc/validators/QqValidator.md)
1. [yii-validator扩展验证安全操作密码 : SecurityOperateValidator](doc/validators/SecurityOperateValidator.md)
1. [yii-validator扩展验证数据是否是用户名格式 : UsernameValidator](doc/validators/UsernameValidator.md)
1. [yii-validator扩展验证数据是否是用户名格式 : ZipCodeValidator](doc/validators/ZipCodeValidator.md)

## 功能集
1. [IP地址解析 : Ip2Location](doc/Ip2Location.md)
1. [常量配置 define-local.php](doc/define-local.md)
1. action操作
    1. \YiiHelper\actions\ClearCache: 系统缓存清理
1. 三方系统管理
    - 控制器: \YiiHelper\features\system\controllers\SystemController
    - 模型: \YiiHelper\features\system\models\Systems
1. 三方系统调用模型: \YiiHelper\models\ClientLogs(\YiiHelper\helpers\client\Client::$openDbLog 为true时，请求记录会记录模型表{{%client_logs}}中)


## 可能排错方式
1. [transmit系统接受不到参数](doc/resolveError/001.transmit系统接受不到参数.md)


## 自有系统代理
- 配置系统: \YiiHelper\proxy\ConfigureProxy
```php
# 配置代理示例 main.php
'proxyConfigure' => [
    'class'       => \YiiHelper\proxy\ConfigureProxy::class,
    'baseUrl'     => 'http://configure.yii.us',
    'systemCode'  => 'configure',
    'enableToken' => true,
    'uuid'        => 'portal',
    'publicKey'   => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC1o1cbhRTFQcQoIXynI6P04fXmxb9NCz6xJK+x37KWSPLQ0XrqY87m1PZC92XDXn/UsXRZpenatE8gEfwawOkC3uGuGcTkk4LFrp/+iodxYxGYDaFrtCaSYwEu0xv585aKr+e22EoJmqYVNS8vAlzNt+',
],
```
- Portal入口系统: \YiiHelper\proxy\PortalProxy
```php
# 配置代理示例 main.php
'proxyPortal'  => [
    'class'       => \YiiHelper\proxy\PortalProxy::class,
    'enableToken' => true,
    'systemCode'  => 'portal',
    'baseUrl'     => 'http://portal.yii.us',
    'uuid'        => 'configure',
    'publicKey'   => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC/rHe57ewHFpVX8lSwd9swNYBhQn5kIo7HMdOgjMEfsIj0FZTFDbyXwnlrLIsMPlARJ/D3v5c5b7fCREIiuVtl0DEG9h0Au5S/y09YURNxENqENPQP+',
],
```

## SQL作用
1. sql/prefix_system.sql: 三方系统登录
1. sql/prefix_client_logs.sql: Client请求访问三方系统开启 openDbLog 时存储访问日志
1. sql/prefix_life_collection.sql: 生命周期数据采用DbStore存储时使用
