<?php

/**
 * 备份还原系统
 * <p>必须库 : CoreDB / CoreFile / CoreHeader</p>
 * <p>备份前注意完全关闭站点，或站点相关存取交互。</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 */
class SysBackup {

    /**
     * 数据库对象
     * @var CoreDB
     */
    private $db;

    /**
     * 备份文件路径
     * @var string 
     */
    private $backupDir;

    /**
     * 路径分隔符
     * @var string 
     */
    private $ds = DIRECTORY_SEPARATOR;

    /**
     * 临时处理目录
     * @var string 
     */
    private $backupTempDir;

    /**
     * 数据库名称
     * @var string 
     */
    private $databaseName;

    /**
     * 初始化
     * @param CoreDB $db 数据库对象
     * @param string $backupDir 备份数据目录
     * @param string $database 数据库名称
     */
    public function __construct(&$db, $backupDir, $databaseName) {
        $this->db = $db;
        $this->backupDir = $backupDir;
        $this->backupTempDir = $backupDir . $this->ds . 'return';
        $this->databaseName = $databaseName;
    }

    /**
     * 备份数据库
     * @return boolean 是否成功备份
     */
    public function backup() {
        $fileName = date(YmdHis) . '.zip';
        $fileSrc = $this->getFileSrc($fileName);
        if (is_file($fileSrc)) {
            return false;
        }
        if ($this->clearTempDir() != true) {
            return false;
        }
        //获取数据表列
        $sql = 'SHOW TABLES FROM ' . $this->databaseName;
        $tableRes = $this->db->runSQL($sql, null, 3, PDO::FETCH_NUM);
        if(!$tableRes){
            return false;
        }
        print_r($tableRes);die();
        return false;
    }

    /**
     * 还原备份文件
     * @param string $name 文件名称
     * @return boolean 是否成功还原
     */
    public function re($name) {
        $src = $this->getFileSrc($name);
        if (!is_file($src)) {
            return false;
        }
        if ($this->clearTempDir() != true) {
            return false;
        }
        return false;
    }

    /**
     * 获取备份文件列
     * @return array 只包含文件名称的数据数组
     */
    public function viewList() {
        $search = $this->backupDir . $this->ds . '*.zip';
        $fileList = CoreFile::searchDir($search);
        if ($fileList) {
            foreach ($fileList as $k => $v) {
                $fileList[$k] = CoreFile::getBasename($v);
            }
            return $fileList;
        }
        return null;
    }

    /**
     * 上传备份文件
     * @param $_FILES $file 备份文件对象
     * @return boolean 是否成功
     */
    public function upload($file) {
        return false;
    }

    /**
     * 删除备份文件
     * @param string $name 文件名称
     * @return boolean 是否成功删除
     */
    public function del($name) {
        $src = $this->getFileSrc($name);
        if (is_file($src)) {
            return false;
        }
        return CoreFile::deleteFile($src);
    }

    /**
     * 下载备份文件
     * @param string $name 文件名称
     */
    public function download($name) {
        $fileSrc = $this->getFileSrc($name);
        if (is_file($fileSrc)) {
            return false;
        }
        $size = filesize($fileSrc);
        CoreHeader::downloadFile($size, $name, $fileSrc);
    }

    /**
     * 获取备份文件路径
     * @param string $name 文件名称
     * @return string 文件路径
     */
    private function getFileSrc($name) {
        $src = $this->backupDir . $this->ds . $name;
        return $src;
    }

    /**
     * 清空临时处理目录
     * @return boolean 是否成功
     */
    private function clearTempDir() {
        if (is_dir($this->backupTempDir)) {
            if (!CoreFile::deleteDir($this->backupTempDir)) {
                return false;
            }
        }
        return CoreFile::newDir($this->backupTempDir);
    }

}

?>