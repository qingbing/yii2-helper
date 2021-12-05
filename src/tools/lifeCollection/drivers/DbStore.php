<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\tools\lifeCollection\drivers;


use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use YiiHelper\tools\lifeCollection\Store;
use Zf\Helper\Format;

/**
 * 驱动 : db管理生命周期数据
 *
 * Class DbStore
 * @package YiiHelper\tools\lifeCollection\drivers
 */
class DbStore extends Store
{
    /**
     * @var Connection
     */
    public $db = 'db';
    /**
     * @var string 数据存储表名
     */
    public $table = '{{%life_collection}}';

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * 从头部移除有效数据
     *
     * @param int $count
     * @return bool
     * @throws \yii\db\Exception
     */
    public function pop(int $count): bool
    {
        $sql = (new Query())
            ->from($this->table)
            ->select(['id'])
            ->where('col_name=:col_name AND expire_at>=:expire_at', [
                ':col_name'  => $this->colName,
                ':expire_at' => $this->nowDatetime,
            ])
            ->orderBy("expire_at ASC")
            ->limit($count)
            ->createCommand()
            ->getRawSql();
        $ids = $this->db
            ->createCommand($sql)
            ->queryColumn();
        if (0 === count($ids)) {
            return true;
        }
        return $this->db->createCommand()
                ->delete($this->table, [
                    'id' => $ids
                ])->execute() > 0;
    }

    /**
     * 获取有效数据数量
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public function getCount(): int
    {
        $sql = (new Query())
            ->from($this->table)
            ->select(['count(*) as count'])
            ->where('col_name=:col_name AND expire_at>=:expire_at', [
                ':col_name'  => $this->colName,
                ':expire_at' => $this->nowDatetime,
            ])
            ->createCommand()
            ->getRawSql();
        $res = $this->db
            ->createCommand($sql)
            ->queryOne();
        return intval($res['count'] ?? 0);
    }

    /**
     * 清理过期数据
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function clearOverdue(): bool
    {
        return $this->db->createCommand()
                ->delete($this->table, [
                    'and',
                    ['<', 'expire_at', $this->nowDatetime]
                ])->execute() > 0;
    }

    /**
     * 新增字符串数据
     *
     * @param string $data
     * @return bool
     * @throws \yii\db\Exception
     */
    protected function push(string $data): bool
    {
        $sql = (new Query())
            ->from($this->table)
            ->where('col_name=:col_name AND data=:data', [
                ':col_name' => $this->colName,
                ':data'     => $data,
            ])
            ->createCommand()
            ->getRawSql();
        $res = $this->db
            ->createCommand($sql)
            ->queryOne();
        if (false === $res) {
            return $this->db->createCommand()
                    ->insert($this->table, [
                        'col_name'  => $this->colName,
                        'data'      => $data,
                        'expire_at' => Format::datetime($this->nowTimestamp + $this->expireTtl)
                    ])
                    ->execute() > 0;
        } else {
            return $this->db->createCommand()
                    ->update($this->table, [
                        'expire_at' => Format::datetime($this->nowTimestamp + $this->expireTtl)
                    ], [
                        'col_name' => $this->colName,
                        'data'     => $data,
                    ])
                    ->execute() > 0;
        }
    }

    /**
     * 获取所有有效的字符串数据
     *
     * @return array
     * @throws \yii\db\Exception
     */
    protected function getAll(): array
    {
        // 查询有效数据
        $sql = (new Query())
            ->from($this->table)
            ->select(['data'])
            ->where('col_name=:col_name AND expire_at>=:expire_at', [
                ':col_name'  => $this->colName,
                ':expire_at' => $this->nowDatetime,
            ])
            ->createCommand()
            ->getRawSql();
        return $this->db
            ->createCommand($sql)
            ->queryColumn();
    }

    /**
     * 判断一个字符串数据是否有效
     *
     * @param string $data
     * @return bool
     * @throws \yii\db\Exception
     */
    protected function isExpire(string $data): bool
    {
        $sql = (new Query())
            ->from($this->table)
            ->select(['id'])
            ->where('col_name=:col_name AND expire_at>=:expire_at AND data=:data', [
                ':col_name'  => $this->colName,
                ':data'      => $data,
                ':expire_at' => $this->nowDatetime,
            ])
            ->createCommand()
            ->getRawSql();
        $res = $this->db
            ->createCommand($sql)
            ->queryAll();
        return count($res) > 0;
    }
}