# 工具: 生命周期集合管理(LifeCollection)
- 提供属性
    - colName: 集合名称
    - expireTtl: 有效期,秒
    - store: 可为数组配置，参考[数据存储器](Store.md)
- 对外提供方法
    - setColName(string $colName): 设置生命周期名称
    - getAllData(): 获取所有有效的数据
    - pushData($data): 新增数据
    - isExpireData($data): 判断数据是否有效
    - pop(int $count): 从头部移除有效数据(移除个数)
    - getCount(): 获取有效数据数量
    - clearOverdue(): 清理过期数据


# coding 示例
```php
$lifeCircle = \Yii::createObject([
    'class'   => LifeCollection::class,
    'colName' => 'life:circle:testing',
    'stroe'   => [
        'redis'        => 'redis',
        'dataTransfer' => 'serialize',
        'expireTtl'    => 7200,
    ],
]);
/* @var LifeCollection $store */
// 新增数据
$lifeCircle->pushData('qingbing');
// 从头部移除有效数据(移除个数)
$lifeCircle->pop(1);
// 获取有效数据数量
$lifeCircle->getCount();
// 获取所有有效的数据
$lifeCircle->getAllData();
// 判断数据是否有效
$lifeCircle->isExpireData('qingbing');
// 清理过期数据
$lifeCircle->clearOverdue();
```
