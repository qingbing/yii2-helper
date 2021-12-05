<?php

namespace YiiHelper\models;

use yii\db\ActiveRecord;
use YiiHelper\abstracts\Model;
use YiiHelper\behaviors\IpBehavior;
use YiiHelper\behaviors\TraceIdBehavior;
use YiiHelper\behaviors\UidBehavior;

/**
 * This is the model class for table "{{%client_logs}}".
 *
 * @property int $id 自增ID
 * @property string $trace_id 客户端日志ID
 * @property string $system_code 系统别名
 * @property string $called_system_code 访问系统别名
 * @property string $full_url 接口URL
 * @property string $method 请求方法[get post put...]
 * @property string $request_time 访问时间
 * @property string|null $request_data 接口发送信息
 * @property int $response_code http状态返回码
 * @property string|null $response_data 接口返回信息
 * @property float $use_time 接口耗时
 * @property string $ip 登录IP
 * @property int $uid 用户ID
 * @property string $created_at 创建时间
 */
class ClientLogs extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_time', 'request_data', 'response_data', 'created_at'], 'safe'],
            [['response_code', 'uid'], 'integer'],
            [['use_time'], 'number'],
            [['trace_id'], 'string', 'max' => 32],
            [['system_code', 'called_system_code'], 'string', 'max' => 50],
            [['full_url'], 'string', 'max' => 200],
            [['method'], 'string', 'max' => 10],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => '自增ID',
            'trace_id'           => '客户端日志ID',
            'system_code'        => '系统别名',
            'called_system_code' => '访问系统别名',
            'full_url'           => '接口URL',
            'method'             => '请求方法[get post put...]',
            'request_time'       => '访问时间',
            'request_data'       => '接口发送信息',
            'response_code'      => 'http状态返回码',
            'response_data'      => '接口返回信息',
            'use_time'           => '接口耗时',
            'ip'                 => '登录IP',
            'uid'                => '用户ID',
            'created_at'         => '创建时间',
        ];
    }

    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT  = 'PUT';

    /**
     * 获取所有请求方式
     *
     * @return array
     */
    public static function methods()
    {
        return [
            self::METHOD_GET  => 'GET',
            self::METHOD_POST => 'POST',
            self::METHOD_PUT  => 'PUT',
        ];
    }

    /**
     * 绑定 behavior
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TraceIdBehavior::class,
            'ip' => [
                'class'      => IpBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'ip',
                ]
            ],
            UidBehavior::class,
        ];
    }
}
