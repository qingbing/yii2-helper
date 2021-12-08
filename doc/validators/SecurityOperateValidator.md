
# 验证类 ： SecurityOperateValidator
yii-validator扩展验证操作安全，需要用户输入安全操作密码

- 属性验证
    - callable: 验证回调函数，返回 bool，优先级高于 method
    - method: 用户模型方法验证
