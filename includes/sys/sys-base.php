<?php

/**
 * 数据库操作基础类
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */
class SysBase {

    /**
     * 数据库句柄
     * @var CoreDB 
     */
    protected $db;

    /**
     * 日志句柄
     * @var SysLog
     */
    private $log;

    public function __construct(&$db, &$log) {
        $this->db = $db;
        $this->log = $log;
    }

    /**
     * 添加日志
     * @param string $message 日志消息
     */
    protected function addLog($message) {
        $this->log->add($message);
    }

    /**
     * 执行SQL
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @param int $resType 返回类型 0-boolean 1-fetch 2-fetchColumn 3-fetchAll 4-lastID
     * @param int $resFetch PDO-FETCH类型，如果返回fetchColumn则为列偏移值
     * @return boolean|PDOStatement 成功则返回PDOStatement句柄，失败返回false
     */
    protected function execSQLPA($sql, $attrs = null, $resType = 0, $resFetch = null) {
        return $this->db->prepareAttr($sql, $attrs, $resType, $resFetch);
    }

    /**
     * 执行无反馈SQL
     * @param string $sql SQL语句
     * @return int returns the number of rows that were modified or deleted by the SQL statement you issued. If no rows were affected, PDO::exec returns 0. 
     * This function may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE. Please read the section on Booleans for more information. 
     * Use the === operator for testing the return value of this function.
     * The following example incorrectly relies on the return value of PDO::exec, wherein a statement that affected 0 rows results in a call to die: $db->exec() or die(print_r($db->errorInfo(), true));
     */
    protected function execSQL($sql) {
        return $this->db->exec($sql);
    }

}

?>
