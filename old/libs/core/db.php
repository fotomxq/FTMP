<?php

/**
 * 数据库处理类
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package core
 */
class CoreDB extends PDO {

    /**
     * 数据库句柄
     * @var PDO 
     */
    private $handle;

    /**
     * PDO-DSN
     * @var string 
     */
    private $dsn;

    /**
     * 数据库用户名
     * @var string
     */
    private $user;

    /**
     * 数据库密码
     * @var string 
     */
    private $pass;

    /**
     * 是否持久化连接
     * @var boolean
     */
    private $persistent;

    /**
     * 连接状态
     * @var boolean 
     */
    private $status;

    /**
     * 编码
     * @var string 
     */
    private $encoding;

    /**
     * 初始化
     * @param string $dsn PDO-DSN
     * @param string $username 用户名
     * @param string $passwd 密码
     * @param boolean $persistent 是否持久化连接
     * @return PDO 连接成功并返回连接句柄，失败返回NULL
     */
    public function __construct($dsn, $username, $passwd, $persistent = true, $encoding = 'utf8') {
        $this->dsn = $dsn;
        $this->user = $username;
        $this->pass = $passwd;
        $this->persistent = $persistent;
        $this->encoding = $encoding;
        $this->connect();
    }

    /**
     * 遍历插入PDO数据
     * @param string $sql SQL语句
     * @param array $attrs 数据数组 eg:array(':id'=>array('value','PDO::PARAM_INT'),...)
     * @param int $resType 返回类型 0-boolean 1-fetch 2-fetchColumn 3-fetchAll 4-lastID
     * @param int $resFetch PDO-FETCH类型，如果返回fetchColumn则为列偏移值
     * @return boolean|PDOStatement 成功则返回PDOStatement句柄，失败返回false
     */
    public function prepareAttr($sql, $attrs = null, $resType = 0, $resFetch = null) {
        try {
            $sth = $this->prepare($sql);
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
                } elseif ($resType == 4) {
                    return $this->lastInsertId();
                } else {
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        } catch (PDOStatement $e) {
            return false;
        }
    }

    /**
     * 连接到数据库
     */
    private function connect() {
        try {
            if ($this->status == false) {
                if (parent::__construct($this->dsn, $this->user, $this->pass, array(PDO::ATTR_PERSISTENT => $this->persistent, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"))) {
                    $this->status = true;
                    $this->setEncoding($this->encoding);
                }
            }
        } catch (PDOException $pdoe) {
            $this->status = false;
        }
    }

    /**
     * 设定编码
     * @param string $encoding 编码名称
     * @return boolean
     */
    private function setEncoding($encoding) {
        $bool = false;
        if ($this->status == true) {
            $sql = 'SET NAMES ' . $encoding . '';
            $bool = $this->exec($sql);
        }
        return $bool;
    }

}

?>