<?php

/**
 * 应用管理类
 * <p>需要类 : CoreFile & CoreDB</p>
 * <p>需要常量 : DS</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package extend
 */

class ExtendReg{
	/**
	 * 数据表名称
	 * @var string
	 */
	private $tableName;

	/**
	 * 数据库操作句柄
	 * @var CoreDB
	 */
	private $db;

	/**
	 * 字段列
	 * @var array
	 */
	private $fields = array('id','reg_app','reg_name','reg_value');

	/**
	 * 字段组合
	 * @var string
	 */
	private $fieldSQL = '';

	/**
	 * 初始化
	 * @param CoreDB $db        数据库句柄
	 * @param string $tableName 数据表名称
	 */
	public function __construct(&$db,$tableName){
		$this->db = $db;
		$this->tableName = $tableName;
		$this->mergeFields();
	}

	/**
	 * 根据ID查看值
	 * @param  int $id ID
	 * @return string 值
	 */
	public function view($id){
		$sql = 'SELECT `'.$this->fields[3].'` FROM `'.$this->tableName.'` WHERE `'.$this->fields[0].'` = :id;';
		$attrs = array(':id'=>array($id,PDO::PARAM_INT));
		$result = $this->db->prepareAttr($sql,$attrs,2,0);
		return $result;
	}

	/**
	 * 根据应用ID和标识查看值
	 * @param  int $appID 应用ID
	 * @param  string $name  标识
	 * @return array 值数组
	 */
	public function viewApp($appID,$name){
		$sql = 'SELECT `'.$this->fields[3].'` FROM `'.$this->tableName.'` WHERE `'.$this->fields[1].'` = :appID and `'.$this->fields[2].'` = :name;';
		$attrs = array(':appID'=>array($appID,PDO::PARAM_INT),':name'=>array($name,PDO::PARAM_STR));
		$result = $this->db->prepareAttr($sql,$attrs,3,PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * 根据应用ID查询所有值
	 * @param  int $appID 应用ID
	 * @return array 值数组
	 */
	public function viewAppAll($appID){
		$sql = 'SELECT '.$this->fieldSQL.' FROM `'.$this->tableName.'` WHERE `'.$this->fields[1].'` = :appID;';
		$attrs = array(':appID'=>array($appID,PDO::PARAM_INT));
		$result = $this->db->prepareAttr($sql,$attrs,3,PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * 添加新的注册项
	 * @param int $appID 应用ID
	 * @param string $name  标识
	 * @param string $value 初始化值
	 */
	public function add($appID,$name,$value){
		$sql = 'INSERT INTO `'.$this->tableName.'`('.$this->fieldSQL.') VALUES(NULL,:appID,:name,:value);';
		$attrs = array(':appID'=>array($appID,PDO::PARAM_INT),':name'=>array($name,PDO::PARAM_STR),':value'=>array($value,PDO::PARAM_STR));
		return $this->db->prepareAttr($sql,$attrs,4);
	}

	/**
	 * 删除ID
	 * @param  int $id ID
	 * @return boolean 是否成功
	 */
	public function delete($id){
		$sql = 'DELETE FROM `'.$this->tableName.'` WHERE `'.$this->fields[0].'` = :id;';
		$attrs = array(':id'=>array($id,PDO::PARAM_INT));
		return $this->db->prepareAttr($sql,$attrs);
	}

	/**
	 * 删除应用ID
	 * @param  int $appID 应用ID
	 * @return boolean 是否成功
	 */
	public function deleteApp($appID){
		$sql = 'DELETE FROM `'.$this->tableName.'` WHERE `'.$this->fields[1].'` = :appID;';
		$attrs = array(':appID'=>array($appID,PDO::PARAM_INT));
		return $this->db->prepareAttr($sql,$attrs);
	}

	/**
	 * 合并字段组合
	 */
	private function mergeFields(){
		$this->fieldSQL = '`'.implode('`,`',$this->fields).'`';
	}
}

?>