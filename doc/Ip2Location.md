# Ip2Location IP地址解析

## 使用了包（已经配置在 qingbing/yii-helper 中）
composer require myweishanli/yii2-ip2location

## test 代码

```php
$ipLocation = new Ip2Location();
$locationModel = $ipLocation->getLocation('8.8.8.8');
print_r($locationModel->toArray());
```

## test 结果

```
Array
(
    [ip] => 8.8.8.8
    [begin_ip] => 8.8.8.8
    [end_ip] => 8.8.8.8
    [country] => 美国
    [area] => 加利福尼亚州圣克拉拉县山景市谷歌公司DNS服务器
)

```
