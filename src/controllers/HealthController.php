<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\controllers;


use Exception;
use yii\helpers\ArrayHelper;
use YiiHelper\abstracts\RestController;
use YiiHelper\filters\ActionFilter;

/**
 * 健康探测类
 *
 * Class HealthController
 * @package YiiHelper\controllers
 */
class HealthController extends RestController
{
    /**
     * @var array|callable|null 在 beforeAction 前需要执行的回调函数
     */
    public $beforeActionCallback;
    /**
     * @var array|callable|null 在 afterAction 前需要执行的回调函数
     */
    public $afterActionCallback;

    /**
     * 定义行为
     *
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'actionCallback' => [
                'class' => ActionFilter::class,
                'only'  => ['index'],
            ]
        ]);
    }

    /**
     * 健康探测
     *
     * @return array
     * @throws Exception
     */
    public function actionIndex()
    {
        return $this->success(true);
    }
}