<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;


use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;
use Zf\Helper\Exceptions\CustomException;
use Zf\Helper\ReqHelper;

/**
 * 基本的队列任务封装
 *
 * Class BaseQueueJob
 * @package YiiHelper\components
 */
abstract class BaseQueueJob extends BaseObject implements JobInterface
{
    /**
     * @var string 队列驱动ID
     */
    public $queueId;
    /**
     * @var bool 是否使用来源时的 traceId
     */
    public $useSourceTraceId = true;
    /**
     * @var string push时的traceId
     */
    public $traceId;
    /**
     * @var mixed 队列数据
     */
    public $payload;
    /**
     * @var Queue
     */
    protected $queue;

    /**
     * BaseQueueJob constructor.
     * @param array $config
     * @throws CustomException
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->queue = Yii::$app->get($this->queueId);

        if (isset($config['queueId']) && !$this->queue instanceof Queue) {
            throw new CustomException("queueId不是有效的Queue驱动");
        }
    }

    /**
     * 设置队列数据
     *
     * @param mixed $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * 想队列推送数据，并返回jobID
     *
     * @return mixed|string|null
     */
    public function push()
    {
        $this->traceId = ReqHelper::getTraceId();
        return $this->queue->push($this);
    }

    /**
     * 反序列化后的操作，主要是一些资源连接等相关事项
     */
    public function __wakeup()
    {
    }

    /**
     * 序列号属性
     *
     * @return array
     */
    public function __sleep()
    {
        return ['traceId', 'payload'];
    }

    /**
     * @param Queue $queue which pushed and is handling the job
     * @return void|mixed result of the job execution
     */
    public function execute($queue)
    {
        if ($this->useSourceTraceId) {
            ReqHelper::setTraceId($this->traceId);
        }
    }
}