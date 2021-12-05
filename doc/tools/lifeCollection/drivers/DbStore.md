# db管理生命周期数据
- 主体属性和方法参考[抽象类 Store](../Store.md)
- 属性
    - db: 存储的db组件id或数组配置
    - table: 数据存储表名

# coding 示例
```php
$store = \Yii::createObject([
    'class'        => DbStore::class,
    'db'           => 'db',
    'table'        => '{{%life_circle}}',
    'colName'      => 'life:circle:testing',
    'dataTransfer' => 'serialize',
    'expireTtl'    => 7200,
]);
/* @var DbStore $store */
// 新增数据
$store->pushData('qingbing');
// 从头部移除有效数据(移除个数)
$store->pop(1);
// 获取有效数据数量
$store->getCount();
// 获取所有有效的数据
$store->getAllData();
// 判断数据是否有效
$store->isExpireData('qingbing');
// 清理过期数据
$store->clearOverdue();
```
