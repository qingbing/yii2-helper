# 抽象类 : 逻辑获取基类 (\YiiHelper\abstracts\BaseLogic)
- 继承自 \Zf\Helper\Abstracts\Factory
- 对外提供方法
    - setParams(array $params) : 设置逻辑参数
    - abstract public function getData() : 获取逻辑数据


## 使用示例
```php
class demo extends \YiiHelper\abstracts\BaseLogic
{
    /**
     * 获取逻辑数据
     *
     * @return mixed
     */
    public function getData()
    {
        //var_dump($this->params);
        return $this->params;
    }
}

$data = demo::getInstance()
    ->setParams([
        'test' => "test-params",
    ])
    ->getData();
var_dump($data);
```
