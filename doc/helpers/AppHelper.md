# Yii-App 辅助类 ： AppHelper
yii应用的常用辅助类
- static getIsBasicYii($vendorName = 'vendor') : 判断使用的是否是yii的基础版
- static getRuntimePath() : 获取 Yii 的运行日志路径
- static getBasePath() : 获取项目基本路径
- static getRootPath($vendorName = 'vendor') : 获取程序根目录
- static getConfigPath($module = null, $vendorName = 'vendor') : 获取配置文件目录
- static getDatabaseName($dsn = null) : 获取 db 连接的 dsn 中的数据库名


## test 代码
```php
var_dump(AppHelper::getIsBasicYii());
var_dump(AppHelper::getRuntimePath());
var_dump(AppHelper::getBasePath());
var_dump(AppHelper::getRootPath());
var_dump(AppHelper::getConfigPath());
var_dump(AppHelper::getConfigPath('common'));
var_dump(AppHelper::getDatabaseName());
```

## test 结果
```text
bool(false)
string(49) "/var/www/html/yii-projects/yii.us/program/runtime"
string(41) "/var/www/html/yii-projects/yii.us/program"
string(33) "/var/www/html/yii-projects/yii.us"
string(48) "/var/www/html/yii-projects/yii.us/program/config"
string(47) "/var/www/html/yii-projects/yii.us/common/config"
string(8) "yii_test"
```