<?php
/**
 * 服务器管理
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */

class SysServer{
	/**
	 * 数据库对象
	 * @var CoreDB
	 */
	private $db;

	/**
	 * 数据表名称
	 * @var string
	 */
	private $tableName;

	/**
	 * 字段列
	 * @var array
	 */
	private $fields = array('id','server_name','server_des','server_ip','server_port');

	/**
	 * 初始化
	 * @param CoreDB $db        数据库对象
	 * @param string $tableName 表名称
	 */
	public function __construct(&$db,$tableName){
		$this->db = $db;
		$this->tableName = $tableName;
	}

	/**
	 * 查看所有服务器
	 * @return array 服务器列
	 */
	public function viewList(){
		return $this->db->sqlSelect($this->tableName,$this->fields,'1',null);
	}

	/**
	 * 查看服务器信息
	 * @param  int $id 索引
	 * @return array     服务器信息
	 */
	public function view($id){
		$where = '`'.$this->fields[0].'` = :id';
		$attrs = array(':id'=>array($id,PDO::PARAM_INT));
		return $this->db->sqlSelect($this->tableName,$this->fields,$where,$attrs);
	}

	/**
	 * 添加新的服务器
	 * @param string $name 服务器名称
	 * @param string $des  描述
	 * @param string $ip   IP地址
	 * @param int $port 端口
	 */
	public function add($name,$des,$ip,$port){
		$val = ':name,:des,:ip,:port';
		$attrs = array(':name'=>array($name,PDO::PARAM_STR),':des'=>array($des,PDO::PARAM_STR),':ip'=>array($ip,PDO::PARAM_STR),':port'=>array($port,PDO::PARAM_STR));
		return $this->db->sqlInsert($this->tableName,$this->fields,$val,$attrs);
	}

	/**
	 * 删除服务器
	 * @param  int $id int
	 * @return boolean     是否成功
	 */
	public function del($id){
		$where = '`'.$this->fields[0].'` = :id';
		$attrs = array(':id'=>array($id,PDO::PARAM_INT));
		return $this->db->sqlDelete($this->tableName,$where,$attrs);
	}
}
?>