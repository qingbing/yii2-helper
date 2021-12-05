# 基本的队列任务封装
- 继承自 \yii\base\BaseObject
- 预定实现接口 \yii\queue\JobInterface
- 属性定义
    - queueId ： 队列驱动ID（componentID）
    - useSourceTraceId ： 在是否在 worker-exec 时使用 push 的 traceId
    - traceId ： push时自动写入的traceId，无需人工管理
    - payload ： 队列数据，建议通过 setPayload() 方法进行设置
    - 每个子任务需要继承 execute($queue) 方法来进行队列处理

## push 举例
```php


return [
    'bootstrap' => ['testQueue'],
    'components' => [
        'testQueue'        => [
            'class'       => \yii\queue\file\Queue::class,
            'path'        => '@runtime/../../common/runtime',
            'as log' => \yii\queue\LogBehavior::class,
            'on beforePush' => function () {
                var_dump(__METHOD__ . " before push");
                Yii::info("before push");
            },
            'on afterPush'  => function () {
                var_dump(__METHOD__ . " after push");
                Yii::info("after push");
            },
            'on beforeExec' => function () {
                var_dump(__METHOD__ . " before exec");
                Yii::info("before exec");
            },
            'on afterExec'  => function () {
                var_dump(__METHOD__ . " after exec");
                Yii::info("after exec");
            },
        ],
    ],
];

class TestQueue extends BaseQueueJob
{
    public $queueId = 'testQueue';

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        parent::execute($queue);
        var_dump($this);
        var_dump(ReqHelper::getTraceId());
    }
}

// 推送
$queue = new TestQueue();
$queue->setPayload(['name' => "qingbing", 'sex' => 'nan'])
    ->push();
```