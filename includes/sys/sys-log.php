<?php

/**
 * 日志操作类
 * <p>额外需要扩展包：CoreFile</p>
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package sys
 */
class SysLog {

    /**
     * 数据库句柄
     * @var CoreDB 
     */
    private $db;

    /**
     * IP地址
     * @var string 
     */
    private $ip;

    /**
     * 数据表
     * @var string 
     */
    private $tableName;

    /**
     * 日志归档目录
     * @var string 
     */
    private $fileDir;

    /**
     * 字段数据
     * @var array 
     */
    private $fields = array('id', 'ip', 'time', 'message');

    /**
     * 初始化
     * @param CoreDB $db 数据库句柄
     * @param string $ip IP地址
     * @param string $dir 归档目录路径
     */
    public function __construct(&$db, $ip, $dir) {
        $this->db = $db;
        $this->ip = $ip;
        $this->tableName = $db->tables['log'];
        $this->fileDir = $dir;
    }

    /**
     * 获取尚未归档的日志列表
     * @param int $page 页数
     * @param int $max 页长
     * @param int $sort 排序字段键值
     * @param boolean $desc 是否倒叙
     * @return array 数据数组，如果不存在返回null
     */
    public function getList($page = 1, $max = 30, $sort = 0, $desc = true) {
        $sortField = isset($this->fields[$sort]) == true ? $this->fields[$sort] : $this->fields[0];
        $descStr = $desc == true ? 'DESC' : 'ASC';
        $sql = 'SELECT (`' . implode('`,`', $this->fields) . '`) FROM `' . $this->tableName . '` ORDER BY `' . $sortField . '` ' . $descStr . ' LIMIT ' . ($page - 1) * $max . ',' . $max;
        return $this->db->prepareAttr($sql, null, 3, PDO::FETCH_ASSOC);
    }

    /**
     * 获取记录数
     * @return int 记录数
     */
    public function getListRow() {
        $sql = 'SELECT count(`' . $this->fields[0] . '`) FROM `' . $this->tableName . '`';
        return $this->db->prepareAttr($sql, null, 2, 0);
    }

    /**
     * 获取归档的结构数据
     * @param string $dir 一级目录名称
     * @return array 归档数据数组，如果不存在则返回null
     */
    public function getFileList($dir = '') {
        if ($dir == '' || strlen($dir) == 6) {
            $src = $this->fileDir;
            if ($dir) {
                $src .= CoreFile::$ds . $dir;
            }
            $list = CoreFile::searchDir($src, GLOB_ONLYDIR);
            return $list;
        }
    }

    /**
     * 添加一个日志
     * @param string $message 日志内容
     * @return boolean 是否成功
     */
    public function add($message) {
        $sql = 'INSERT INTO `' . $this->tableName . '`(`' . implode('`,`', $this->fields) . '`) VALUES(NULL,:ip,NOW(),:message)';
        $attrs = array(':ip' => array($this->ip, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT), ':message' => array($message, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT));
        return $this->db->prepareAttr($sql, $attrs);
    }

    /**
     * 归档日志数据
     * <p>只归档前一天之前的日志数据。</p>
     * @return boolean 是否成功
     */
    public function file() {
        $sql = 'SELECT (`' . implode('`,`', $this->fields) . '`) FROM `' . $this->tableName . '` LIMIT :step,50';
        $step = 0;
        do {
            $attrs = array(':step' => array($step, PDO::PARAM_INT));
            $res = $this->db->prepareAttr($sql, $attrs, 3, PDO::FETCH_ASSOC);
            if ($res) {
                foreach ($res as $v) {
                    $time = $v[$this->fields[2]];
                    $ip = $v[$this->fields[1]];
                    $dateYm = substr($time, 0, 4) . substr($time, 5, 2);
                    $dateD = substr($time, 8, 2);
                    $content = $time . ' ' . $ip . ' ' . $ip . "\r\n";
                    if ($this->addFileContent($dateYm, $dateD, $content) == false) {
                        return false;
                    }
                }
            }
            $step++;
        } while ($res);
        return $this->clearTable();
    }

    /**
     * 获取指定年月的目录
     * @param int $dateYm 年月
     * @param int $dateD 日
     * @return string 目录路径
     */
    private function getDir($dateYm, $dateD) {
        $dir = $this->fileDir . CoreFile::$ds . $dateYm;
        if (CoreFile::newDir($dir) == true) {
            return $dir;
        }
        return false;
    }

    /**
     * 向文件添加内容
     * @param int $dateYm 年月
     * @param int $dateD 日
     * @param string $content 添加的内容
     * @return boolean 是否成功
     */
    private function addFileContent($dateYm, $dateD, $content) {
        $dir = $this->getDir($dateYm, $dateD);
        if ($dir) {
            $fileName = $dir . CoreFile::$ds . $dateYm . $dateD . '.log';
            return CoreFile::saveFile($fileName, $content, true);
        }
        return false;
    }

    /**
     * 清空数据表
     * @return boolean 是否成功
     */
    private function clearTable() {
        $sql = 'TRUNCATE `' . $this->tableName . '`';
        return $this->db->prepareAttr($sql);
    }

}

?>
