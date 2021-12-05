<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\tools\lifeCollection;


use yii\base\BaseObject;
use Zf\Helper\Format;

/**
 * 抽象工具 : 生命周期数据管理
 *
 * Class Store
 * @package YiiHelper\tools\lifeCollection
 */
abstract class Store extends BaseObject
{
    /**
     * @var string 集合名称
     */
    public $colName;
    /**
     * @var int 有效期
     */
    public $expireTtl = 7200;
    /**
     * @var array 数据转换类型，serialize,json,base64
     */
    public $dataTransfer;
    /**
     * @var int 当前时间戳
     */
    protected $nowTimestamp;
    /**
     * @var string 当前时间
     */
    protected $nowDatetime;

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->nowTimestamp = time();
        $this->nowDatetime  = Format::datetime($this->nowTimestamp);
    }

    /**
     * 数据处理
     *
     * @param mixed $data
     * @return false|string
     */
    protected function encodeData($data)
    {
        switch ($this->dataTransfer) {
            case 'serialize':
                return serialize($data);
            case 'json':
                return json_encode($data, JSON_UNESCAPED_UNICODE);
            case 'base64':
                return base64_encode($data);
            default:
                return $data;
        }
    }

    /**
     * 还原数据
     *
     * @param string $data
     * @return bool|mixed|string
     */
    protected function decodeData($data)
    {
        switch ($this->dataTransfer) {
            case 'serialize':
                return unserialize($data);
            case 'json':
                return json_decode($data, true);
            case 'base64':
                return base64_decode($data);
            default:
                return $data;
        }
    }

    /**
     * 获取所有有效的数据
     *
     * @return array
     */
    public function getAllData(): array
    {
        $data = $this->getAll();
        $R    = [];
        foreach ($data as $datum) {
            $R[] = $this->decodeData($datum);
        }
        return $R;
    }

    /**
     * 新增数据
     *
     * @param mixed $data
     * @return bool
     */
    public function pushData($data): bool
    {
        return $this->push($this->encodeData($data));
    }

    /**
     * 判断数据是否有效
     *
     * @param mixed $data
     * @return bool
     */
    public function isExpireData($data): bool
    {
        return $this->isExpire($this->encodeData($data));
    }

    /**
     * 从头部移除有效数据
     *
     * @param int $count
     * @return bool
     */
    abstract public function pop(int $count): bool;

    /**
     * 获取有效数据数量
     *
     * @return int
     */
    abstract public function getCount(): int;

    /**
     * 清理过期数据
     *
     * @return bool
     */
    abstract public function clearOverdue(): bool;

    /**
     * 新增字符串数据
     *
     * @param string $data
     * @return bool
     */
    abstract protected function push(string $data): bool;

    /**
     * 获取所有有效的字符串数据
     *
     * @return array
     */
    abstract protected function getAll(): array;

    /**
     * 判断一个字符串数据是否有效
     *
     * @param string $data
     * @return bool
     */
    abstract protected function isExpire(string $data): bool;
}