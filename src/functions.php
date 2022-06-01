<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

use Zf\PhpUpload\base\BaseUpload;

if (!function_exists('permanent_upload_file')) {
    /**
     * 持久化临时文件
     *
     * @param string $tmpFile
     * @param string $uploadComponentId
     * @return string
     * @throws \Zf\Helper\Exceptions\UnsupportedException
     * @throws \yii\base\InvalidConfigException
     */
    function permanent_upload_file($tmpFile, $uploadComponentId = 'upload')
    {
        if (empty($tmpFile)) {
            return "";
        }
        $uploadComponentId = $uploadComponentId ?? (Yii::$app->params['uploadComponent'] ?: null);
        if (empty($uploadComponentId)) {
            return "";
        }
        if (!Yii::$app->has($uploadComponentId)) {
            return "";
        }
        $upload = Yii::$app->get($uploadComponentId);
        if (!$upload instanceof BaseUpload) {
            return "";
        }
        $tmpFolder = $upload->tmpFolder;
        $pos       = strpos($tmpFile, $tmpFolder);
        if (0 === $pos) {
            $newFile = substr($tmpFile, strlen($tmpFolder));
        } else {
            $newFile = $tmpFile;
        }
        $upload->move($tmpFile, $newFile);
        $upload->setLifeTime($newFile, 0);
        return $newFile;
    }
}

if (!function_exists('replace_upload_file')) {
    /**
     * 新增文件 $file, 删除文件(设置有效期) $oldFile
     *
     * @param string $file
     * @param string $oldFile
     * @param string $uploadComponentId
     * @return bool
     * @throws \Zf\Helper\Exceptions\UnsupportedException
     * @throws \yii\base\InvalidConfigException
     */
    function replace_upload_file($file, $oldFile, $uploadComponentId = 'upload')
    {
        if ($file == $oldFile) {
            return true;
        }
        $uploadComponentId = $uploadComponentId ?? (Yii::$app->params['uploadComponent'] ?: null);
        if (empty($uploadComponentId)) {
            return true;
        }
        if (!Yii::$app->has($uploadComponentId)) {
            return true;
        }
        $upload = Yii::$app->get($uploadComponentId);
        if (!$upload instanceof BaseUpload) {
            return true;
        }
        if (!empty($oldFile)) {
            $upload->setLifeTime($oldFile, 1);
        }
        if (!empty($file)) {
            $upload->setLifeTime($file, 0);
        }
        return true;
    }
}

if (!function_exists('delete_upload_file')) {
    /**
     * 删除文件(设置有效期)
     *
     * @param string $file
     * @param string $uploadComponentId
     * @return bool
     * @throws \Zf\Helper\Exceptions\UnsupportedException
     * @throws \yii\base\InvalidConfigException
     */
    function delete_upload_file($file, $uploadComponentId = 'upload')
    {
        $uploadComponentId = $uploadComponentId ?? (Yii::$app->params['uploadComponent'] ?: null);
        if (empty($uploadComponentId)) {
            return true;
        }
        if (!Yii::$app->has($uploadComponentId)) {
            return true;
        }
        $upload = Yii::$app->get($uploadComponentId);
        if (!$upload instanceof BaseUpload) {
            return true;
        }
        if (!empty($file)) {
            $upload->del($file);
        }
        return true;
    }
}
