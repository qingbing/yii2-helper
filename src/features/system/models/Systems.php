<?php

namespace YiiHelper\features\system\models;

use Yii;
use YiiHelper\abstracts\Model;
use Zf\Helper\Exceptions\ProgramException;

/**
 * This is the model class for table "{{%route_systems}}".
 *
 * @property int $id 自增ID
 * @property string $code 系统别名
 * @property string $name 系统名称
 * @property string $description 描述
 * @property string $uri_prefix 系统调用时访问URI前缀
 * @property string $type 系统类型[inner->当前系统；transfer->当前系统转发；outer->外部系统]
 * @property string $proxy_id 参数验证通过后的代理组件ID
 * @property string|null $ext 扩展字段数据
 * @property int $is_enable 系统是否启用状态[0:未启用; 1:已启用]，未启用抛异常
 * @property int $is_allow_new_interface 是否允许未注册接口[0:不允许; 1:允许]
 * @property int $is_record_field 是否记录新接口文档[0:抛异常; 1:继续调用]
 * @property int $is_open_validate 开启接口校验[0:不启用; 1:已启用]
 * @property int $is_strict_validate 开启严格校验[0:未启用; 1:已启用],启用是每个字段都必须在{interface_fields}中定义
 * @property int $sort_order 显示排序
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Systems extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%systems}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['ext', 'created_at', 'updated_at'], 'safe'],
            [['is_enable', 'is_allow_new_interface', 'is_record_field', 'is_open_validate', 'is_strict_validate', 'sort_order'], 'integer'],
            [['code', 'proxy_id'], 'string', 'max' => 50],
            [['name', 'uri_prefix'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            [['code'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                     => '自增ID',
            'code'                   => '系统别名',
            'name'                   => '系统名称',
            'description'            => '描述',
            'uri_prefix'             => '系统调用时访问URI前缀',
            'type'                   => '系统类型[inner->当前系统；transfer->当前系统转发；outer->外部系统]',
            'proxy_id'               => '参数验证通过后的代理组件ID',
            'ext'                    => '扩展字段数据',
            'is_enable'              => '系统是否启用状态[0:未启用; 1:已启用]，未启用抛异常',
            'is_allow_new_interface' => '是否允许未注册接口[0:不允许; 1:允许]',
            'is_record_field'        => '是否记录新接口文档[0:抛异常; 1:继续调用]',
            'is_open_validate'       => '开启接口校验[0:不启用; 1:已启用]',
            'is_strict_validate'     => '开启严格校验[0:未启用; 1:已启用],启用是每个字段都必须在{interface_fields}中定义',
            'sort_order'             => '显示排序',
            'created_at'             => '创建时间',
            'updated_at'             => '更新时间',
        ];
    }

    const TYPE_INNER    = 'inner';
    const TYPE_TRANSFER = 'transfer';
    const TYPE_OUTER    = 'outer';

    /**
     * 系统类型
     *
     * @return array
     */
    public static function types()
    {
        return [
            self::TYPE_INNER    => '当前系统', // inner
            self::TYPE_TRANSFER => '转发系统', // transfer
            self::TYPE_OUTER    => '外部系统', // outer
        ];
    }

    /**
     * 通过系统标记查找系统模型
     *
     * @param string $code
     * @return Systems|null
     */
    public static function getByCode(string $code)
    {
        return self::findOne([
            'code' => $code,
        ]);
    }

    /**
     * 通过关键字获取扩展值
     *
     * @param null|string $key
     * @param null|mixed $default
     * @return mixed|null
     */
    public function getExtValueByKey(?string $key = null, $default = null)
    {
        return $this->ext[$key] ?? $default;
    }

    /**
     * 获取缓存中的系统信息模型
     *
     * @param string $code
     * @return bool|Systems
     */
    public static function getCacheSystem(string $code)
    {
        // 调用频率太高，这里使用缓存获取，减少db的查询，无逻辑，这里不设置db依赖
        return Yii::$app->cacheHelper->get(Yii::$app->id . ":system:{$code}", function () use ($code) {
            $system = Systems::findOne([
                'code' => $code,
            ]);
            if (null === $system) {
                throw new ProgramException("系统「{$code}」不存在");
            }
            return $system;
        }, 300);
    }
}
