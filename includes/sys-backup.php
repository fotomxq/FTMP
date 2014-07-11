<?php

/**
 * 备份还原系统
 * <p>必须库 : CoreDB / CoreFile / CoreHeader</p>
 * <p>备份前注意完全关闭站点，或站点相关存取交互。</p>
 * @author fotomxq <fotomxq.me>
 * @version 2
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
     * 文件数据目录
     * @var string 
     */
    private $contentDir;

    /**
     * 文件数据目录名称
     * @var string 
     */
    private $contentDirName = 'content';

    /**
     * 初始化
     * @param CoreDB $db 数据库对象
     * @param string $backupDir 备份数据目录
     * @param string $contentDir 备份数据目录
     */
    public function __construct(&$db, $backupDir, $contentDir) {
        $this->db = $db;
        $this->backupDir = $backupDir;
        $this->backupTempDir = $backupDir . $this->ds . 'return';
        $this->contentDir = $contentDir;
    }

    /**
     * 备份数据库
     * <p>结构 : 备份文件/sql - SQL目录 ; ./content - 文件数据目录(内部结构和现文件数据完全匹配) ; ./sql/表名称 - 对应表数据目录</p>
     * @param string $type 备份类型,eg: both - 全部 ; sql - 仅sql ; file - 仅文件
     * @return boolean 是否成功备份
     */
    public function backup($type) {
        //创建zip路径
        $fileName = date(YmdHis) . '.zip';
        $fileSrc = $this->getFileSrc($fileName);
        if (is_file($fileSrc)) {
            return false;
        }
        //清理return缓冲目录
        if ($this->clearTempDir() != true) {
            return false;
        }
        if ($type == 'both' || $type == 'sql') {
            //获取数据表列
            $tableRes = $this->getTables();
            if (!$tableRes) {
                return false;
            }
            //创建sql存储路径
            $sqlDir = $this->backupTempDir . $this->ds . 'sql';
            if (CoreFile::newDir($sqlDir) != true) {
                return false;
            }
            //遍历表
            foreach ($tableRes as $tableV) {
                //创建表目录
                $tableVDir = $sqlDir . $this->ds . $tableV[0];
                if (CoreFile::newDir($tableVDir) != true) {
                    return false;
                }
                //遍历得到数据
                $step = 0;
                $max = 50;
                $sql = 'SELECT * FROM `' . $tableV[0] . '` LIMIT ' . $step . ',' . $max;
                $vData = $this->db->runSQL($sql, null, 3, PDO::FETCH_ASSOC);
                //生成sql前缀部分
                $tableVSql = '';
                while ($vData) {
                    //创建存储文件
                    $vDataFile = $tableVDir . $this->ds . $step . '.sql';
                    if (is_file($vDataFile) != false) {
                        return false;
                    }
                    //生成sql数据
                    //获取字段
                    if ($tableVSql == '') {
                        $vSqlField = '';
                        foreach ($vData[0] as $kField => $vValue) {
                            $vSqlField .= '`' . $kField . '`,';
                        }
                        $vSqlField = substr($vSqlField, 0, -1);
                        $tableVSql = 'INSERT INTO ' . $tableV[0] . '(' . $vSqlField . ') VALUES';
                    }
                    //生成记录
                    $vSql = '';
                    foreach ($vData as $row) {
                        $value = '';
                        foreach ($row as $vRow) {
                            if ($vRow) {
                                $vRow = str_replace('\'', '\\\'', $vRow);
                                $value .= '\'' . $vRow . '\',';
                            } else {
                                $value .= 'NULL,';
                            }
                        }
                        $value = substr($value, 0, -1);
                        $vSql .= '(' . $value . '),';
                    }
                    //去掉尾巴
                    $vSql = substr($vSql, 0, -1);
                    $vSql = $tableVSql . $vSql . ';';
                    //将数据存入文件
                    if (CoreFile::saveFile($vDataFile, $vSql, true) != true) {
                        return false;
                    }
                    //获取下一轮数据
                    $step += 1;
                    $sql = 'SELECT * FROM `' . $tableV[0] . '` LIMIT ' . ($step * $max) . ',' . $max;
                    $vData = $this->db->runSQL($sql, null, 3, PDO::FETCH_ASSOC);
                }
            }
        }
        if ($type == 'both' || $type == 'file') {
            //创建data存储路径
            $dataDir = $this->backupTempDir . $this->ds . $this->contentDirName;
            if (CoreFile::newDir($dataDir) != true) {
                return false;
            }
            //复制数据到data路径
            $contentList = CoreFile::searchDir($this->contentDir . $this->ds . '*');
            foreach ($contentList as $dirV) {
                $baseName = CoreFile::getBasename($dirV);
                if ($baseName == 'backup') {
                    continue 1;
                }
                $newSrc = $dataDir . $this->ds . $baseName;
                if (CoreFile::copyDir($dirV, $newSrc) != true) {
                    return false;
                }
            }
        }
        //生成zip文件
        if (CoreFile::createZip($this->backupTempDir, $fileSrc, false) != true) {
            return false;
        }
        //清理return缓冲目录
        if ($this->clearTempDir() != true) {
            return false;
        }
        return true;
    }

    /**
     * 还原备份文件
     * @param string $name 文件名称
     * @return boolean 是否成功还原
     */
    public function re($name) {
        //判断压缩包是否存在
        $zipSrc = $this->getFileSrc($name);
        if (!is_file($zipSrc)) {
            return false;
        }
        //清空return缓冲目录
        if ($this->clearTempDir() != true) {
            return false;
        }
        //将zip数据解压到缓冲目录
        if (CoreFile::extractZip($zipSrc, $this->backupDir) != true) {
            return false;
        }
        //分析数据完整性
        $sqlDir = $this->backupTempDir . $this->ds . 'sql';
        $contentDir = $this->backupTempDir . $this->ds . $this->contentDirName;
        $contentReady = false;
        $sqlReady = false;
        $contentReady = is_dir($contentDir);
        $sqlReady = is_dir($sqlDir);
        if ($contentReady == true) {
            //将现有文件数据清空
            $contentList = CoreFile::searchDir($this->contentDir . $this->ds . '*');
            foreach ($contentList as $dirV) {
                $baseName = CoreFile::getBasename($dirV);
                if ($baseName == 'backup') {
                    continue 1;
                }
                if (CoreFile::deleteDir($dirV) != true) {
                    //return false;
                }
            }
            //将备份文件数据复制到文件数据
            $backupContentList = CoreFile::searchDir($this->backupTempDir . $this->ds . $this->contentDirName . $this->ds . '*');
            foreach ($backupContentList as $dirV) {
                $baseName = CoreFile::getBasename($dirV);
                if ($baseName == 'backup') {
                    continue 1;
                }
                $newSrc = $this->contentDir . $this->ds . $baseName;
                if (CoreFile::copyDir($dirV, $newSrc) != true) {
                    return false;
                }
            }
        }
        if ($sqlReady == true) {
            //清空所有表
            $tableRes = $this->getTables();
            if (!$tableRes) {
                return false;
            }
            foreach ($tableRes as $tableV) {
                if ($this->clearTable($tableV[0]) != true) {
                    return false;
                }
            }
            //遍历表目录
            $sqlDirList = CoreFile::searchDir($sqlDir . $this->ds . '*');
            foreach ($sqlDirList as $sqlDirV) {
                if (is_dir($sqlDirV) != true) {
                    continue 1;
                }
                $sqlFileList = CoreFile::searchDir($sqlDirV . $this->ds . '*.sql');
                if (!$sqlFileList) {
                    continue 1;
                }
                //根据备份文件创建表记录
                foreach ($sqlFileList as $sqlFileV) {
                    $sqlContent = CoreFile::loadFile($sqlFileV);
                    $this->db->runSQLExec($sqlContent);
                }
            }
        }
        //清空return缓冲目录
        if ($this->clearTempDir() != true) {
            return false;
        }
        return true;
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

    /**
     * 获取数据库内所有表
     * @return array 数据数组 eg:array(0=>'表1',1=>'表2',...)
     */
    private function getTables() {
        $sql = 'SHOW TABLES';
        $res = $this->db->runSQL($sql, null, 3, PDO::FETCH_NUM);
        return $res;
    }

    /**
     * 清空表
     * @param string $table 表名称
     * @return boolean 是否成功
     */
    private function clearTable($table) {
        $sql = 'TRUNCATE ' . $table;
        return $this->db->runSQL($sql, null, 0);
    }

}

?>