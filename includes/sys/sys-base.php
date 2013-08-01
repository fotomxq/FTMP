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
    private $db;

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
     * 执行sql-select
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @param int $resType 返回类型 1-fetch 2-fetchColumn 3-fetchAll
     * @param int $resFetch PDO-FETCH类型
     * @return boolean|PDOStatement 成功则返回PDOStatement句柄，失败返回null
     */
    protected function execSQLSelect($sql, $attrs = null, $resType = 1, $resFetch = null) {
        try {
            $sth = $this->db->prepare($sql);
            if ($attrs != null) {
                foreach ($attrs as $k => $v) {
                    if (is_array($v) == true) {
                        $sth->bindParam($k, $v[0], $v[1]);
                    } else {
                        $sth->bindParam($k, $v);
                    }
                }
            }
            if ($sth->execute() == true) {
                if ($resType == 1) {
                    return $sth->fetch($resFetch);
                } elseif ($resType == 2) {
                    return $sth->fetchColumn($resFetch);
                } elseif ($resType == 3) {
                    return $sth->fetchAll($resFetch);
                }
            }
            return null;
        } catch (PDOException $e) {
            return null;
        } catch (PDOStatement $e) {
            return null;
        }
    }

    /**
     * 执行sql-insert
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @return int 插入ID值
     */
    protected function execSQLInsert($sql, $attrs = null) {
        if ($this->execSQLBoolean($sql, $attrs) == true) {
            return $this->db->lastInsertId();
        }
        return 0;
    }

    /**
     * 执行sql-update
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @return boolean 是否成功
     */
    protected function execSQLUpdate($sql, $attrs) {
        return $this->execSQLBoolean($sql, $attrs);
    }

    /**
     * 执行sql-delete
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @return boolean 是否成功
     */
    protected function execSQLDelete($sql, $attrs) {
        return $this->execSQLBoolean($sql, $attrs);
    }

    /**
     * 执行SQL-boolean类语句
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @return boolean 是否成功
     */
    private function execSQLBoolean($sql, $attrs = null) {
        try {
            $sth = $this->db->prepare($sql);
            if ($attrs != null) {
                foreach ($attrs as $k => $v) {
                    if (is_array($v) == true) {
                        $sth->bindParam($k, $v[0], $v[1]);
                    } else {
                        $sth->bindParam($k, $v);
                    }
                }
            }
            return $sth->execute();
        } catch (PDOException $e) {
            return false;
        } catch (PDOStatement $e) {
            return false;
        }
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
