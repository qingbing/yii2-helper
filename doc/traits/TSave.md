# 制作保存失败抛出异常片段 TSave

- 该片段适用于 \yii\db\ActiveRecord 的子类在save数据时使用
- 具体为在 db-insert 和 db-update 时使用
- 可用方法
    - 保存数据，如果保存不成功，直接跑出异常 ： saveOrException($runValidation = true, $attributeNames = null)
