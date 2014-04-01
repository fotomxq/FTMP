<?php
/**
 * 评论处理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */

class SysComment{
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
	 * 字段组
	 * @var array
	 */
	private $fields = array('id','post_id','comment_author','comment_content','comment_date','comment_ip','comment_parent','comment_sha1','user_id');

	/**
	 * 状态
	 * 0-等待审核;1-发布;2-垃圾;3-回收站
	 * @var array
	 */
	private $status = array(0,1,2,3);

	/**
	 * 初始化
	 * @param CoreDB $db        数据库对象
	 * @param string $tableName 数据表名称
	 */
	public function __construct(&$db,$tableName){
		$this->db = $db;
		$this->tableName = $tableName;
	}

	public function add($data){
		$sql = 'INSERT INTO `'.$this->tableName.'`() VALUES()';
		return false;
	}
	public function edit($id,$data){
		$sql = '';
	}
	public function del($id){
	}
	public function delPOST($postID){
	}

	/**
	 * 删除所有评论
	 * @return [type] [description]
	 */
	public function delAll(){
		$sql = 'DELETE FROM `'.$this->tableName.'`';
		return $this->db->runSQLExec($sql);
	}

	/**
	 * 查询评论个数
	 * @param  int $postID POST ID,如果统计全部则为0
	 * @return int          评论个数
	 */
	public function getCount($postID = 0){
		$sql = 'SELECT COUNT(`'.$this->fields[0].'`) FROM `'.$this->tableName.'` WHERE ';
		$attrs = null;
		if($postID == 0){
			$sql .= '1';
		}else{
			$sql .= '`'.$this->fields[1].'` = :postID';
			$attrs = array(':postID'=>array($postID,PDO::PARAM_INT));
		}
		return $this->db->runSQL($sql,$attrs,2,0);
	}

	/**
	 * 获取SHA1
	 * @param  string $str 字符串
	 * @return string      SHA1
	 */
	private function getSHA1(&$str){
		return sha1($str);
	}
}

?>