<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\actions;


use yii\base\Action;
use YiiHelper\helpers\AppHelper;
use YiiHelper\traits\TResponse;
use Zf\Helper\FileHelper;

/**
 * 操作类 ： 系统缓存清理
 *
 * Class ActionClearCache
 * @package YiiHelper\actions
 */
class ActionClearCache extends Action
{
    use TResponse;
    /**
     * @var array 忽略，不清理的文件或文件夹列表
     */
    public $ignores = [
        '.gitignore'
    ];

    /**
     * 运行操作
     *
     * @return array
     * @throws \Exception
     */
    public function run()
    {
        $runtime = AppHelper::getRuntimePath();
        // 遍历目录，按需清理文件和文件夹
        $dp = @opendir($runtime);
        while ($fp = @readdir($dp)) {
            if ('.' === $fp || '..' === $fp) {
                continue;
            }
            if (in_array($fp, $this->ignores)) {
                continue;
            }
            $file = "{$runtime}/$fp";

            if (is_file($file)) {
                @unlink($file);
                continue;
            }
            if (is_dir($file)) {
                FileHelper::rmdir($file, true);
            }
        }
        @closedir($dp);
        AppHelper::app()->cacheHelper->flush();
        return $this->success(true, '缓存清理成功');
    }
}