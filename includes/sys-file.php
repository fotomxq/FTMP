<?php

/**
 * 文件管理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */

class SysFile{
	/**
	 * 数据库对象
	 * @var CoreDB
	 */
	private $db;

	/**
	 * 缓冲器对象
	 * @var CoreCache
	 */
	private $cache;

	/**
	 * 文件保存目录
	 * @var string
	 */
	private $fileDir;

	/**
	 * 文件路径分隔符
	 * @var string
	 */
	private $ds = DIRECTORY_SEPARATOR;

	/**
	 * 数据表名称
	 * @var string
	 */
	private $fileTableName;

	/**
	 * 数据表字段
	 * @var array
	 */
	private $fileFields = array('id','file_name','file_src','file_date','file_sha1','file_size','file_type');

	/**
	 * 初始化
	 * @param CoreDB 	$db        		数据库对象
	 * @param CoreCache $cache  		缓冲器对象
	 * @param string 	$fileDir 		文件保存目录
	 * @param string 	$fileTableName 	数据表名称
	 */
	public function __construct(&$db,&$cache,$fileDir,$fileTableName){
		$this->db = $db;
		$this->cache = $cache;
		$this->fileDir = $fileDir;
		$this->fileTableName = $fileTableName;
	}

	/**
	 * 获取文件信息
	 * @param  int $id 文件ID
	 * @return array 文件信息
	 */
	public function view($id){
		$where = '`'.$this->fileFields[0].'` = :id';
		$attrs = array(':id'=>array($id,PDO::PARAM_INT));
		return $this->db->sqlSelect($this->fileTableName,$this->fileFields,$where,$attrs);
	}

	/**
	 * 查询文件
	 * @param  string  $where 条件语句
	 * @param  array  $attrs 条件筛选
	 * @param  int $page  页数
	 * @param  int $max   页长
	 * @param  int $sort  排序字段键
	 * @param  boolean $desc  是否倒叙
	 * @return array 文件信息列
	 */
	public function search($where,$attrs,$page=1,$max=10,$sort=0,$desc=true){
		$sortField = isset($this->fileFields[$sort]) == true ? $this->fileFields[$sort] : $this->fileFields[0];
		return $this->db->sqlSelect($this->fileTableName,$this->fileFields,$where,$attrs,$page,$max,$sortField,$desc);
	}

	/**
	 * 上传新的文件
	 * @param  $_FILE $uploadfile 上传的文件
	 * @return int             新的文件ID，如果失败则返回0
	 */
	public function upload($uploadfile){
		if(is_uploaded_file($uploadfile['tmp_name']) == true){
			$fileName = $uploadfile['name'];
			return $this->createFile($uploadfile['tmp_name'],$fileName);
		}
		return 0;
	}

	/**
	 * 移动本地文件入库
	 * @param  string $src 文件路径
	 * @return int             新的文件ID，如果失败则返回0
	 */
	public function move($src){
		return $this->createFile($src,basename($src));
	}

	/**
	 * 删除文件
	 * @param  int $id 文件ID
	 * @return boolean 是否删除成功
	 */
	public function del($id){
		//获取文件路径
		$res = $this->view($id);
		if($res){
			//删除文件
			if(CoreFile::isFile($res[$this->fileFields[2]]) == true){
				if(CoreFile::deleteFile($res[$this->fileFields[2]]) == true){
					//删除文件信息
					$where = '`'.$this->fileFields[0].'` = :id';
					$attrs = array(':id'=>array($id,PDO::PARAM_INT));
					return $this->db->sqlDelete($this->fileTableName,$where,$attrs);
				}
			}
		}
	}

	/**
	 * 检查重复文件
	 * @return array 重复文件列，如果没有则返回null
	 */
	public function checkRepeat(){
		return null;
	}

	/**
	 * 检查文件信息匹配度
	 * <p>检查文件信息和真实文件是否匹配，并存在。</p>
	 * @param int $page 步数，数据过大时分段执行
	 * @return array 检查结果，如果没有则返回null
	 */
	public function checkInfos($page=null){
		return null;
	}

	/**
	 * 优化文件结构
	 * <p>需要配合检查结果使用。</p>
	 * @param  array $arr 检查结果
	 * @return boolean 优化是否成功
	 */
	public function optimizationFile($arr){
		return false;
	}

	/**
	 * 创建新的文件记录
	 * @param  string  $src      文件路径
	 * @param  string  $name     文件名称
	 * @param  boolean $isUpload 是否是上传文件
	 * @return int            文件ID，如果失败则返回0
	 */
	private function createFile($src,$name,$isUpload=true){
		$date = $this->getTime();
		$sha1 = $this->getSha1($src);
		$fileSize = $this->getSize($src);
		$fileType = $this->getTypeMeta($src);
		$fileSrc = $this->createNewSrc($date,$sha1);
		if($isUpload == true){
			if(!CoreFile::moveUpload($src,$fileSrc)){
				return 0;
			}
		}else{
			if(!CoreFile::cutF($src,$fileSrc)){
				return 0;
			}
		}
		$vals = 'NULL,:name,:src,:date,:sha1,:size,:type';
		$attrs = array(':name'=>array($name,PDO::PARAM_STR),':src'=>array($fileSrc,PDO::PARAM_STR),':date'=>array($date,PDO::PARAM_STR),':sha1'=>array($sha1,PDO::PARAM_STR),':size'=>array($fileSize,PDO::PARAM_INT),':type'=>array($fileType,PDO::PARAM_STR));
		return $this->db->sqlInsert($this->fileTableName,$this->fileFields,$vals,$attrs);
	}

	/**
	 * 获取新的文件路径
	 * @param  string $date 日期时间
	 * @param  string $sha1 文件SHA1值
	 * @return string       文件路径
	 */
	private function createNewSrc($date,$sha1){
		return $this->fileDir.$this->ds.substr($date,0,4).substr($date,5,2).$this->ds.substr($date,8,2).$this->ds.$sha1;
	}

	/**
	 * 获取当前时间
	 * @return string 时间
	 */
	private function getTime(){
		return Date('Y-m-d H:i:s');
	}

	/**
	 * 获取文件大小KB
	 * @param  string $src 文件路径
	 * @return int      文件大小KB
	 */
	private function getSize($src){
		return file_size($src) / 1024;
	}

	/**
	 * 获取文件Meta文件类型
	 * @param  string $src 文件路径
	 * @return string      文件类型
	 */
	private function getTypeMeta($src){
		return mime_content_type($src);
	}

	/**
	 * 获取文件SHA1值
	 * @param  string $src 文件路径
	 * @return string      文件SHA1
	 */
	private function getSha1($src){
		return sha1_file($src);
	}
}

?>