<?php
/**
 * POST处理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */

class SysPost{
	/**
	 * 数据库对象
	 * @var CoreDB
	 */
	private $db;

	/**
	 * POST数据表名称
	 * @var [type]
	 */
	private $tableNamePost;

	/**
	 * 元数据表名称
	 * @var string
	 */
	private $tableNameMeta;

	/**
	 * 字段组
	 * @var array
	 */
	private $fields = array('id','post_title','post_content','user_id','post_status','post_date','post_passwd','post_parent','post_parent','post_name','post_type','post_sha1','comment_open','comment_count','menu_order');

	/**
	 * 状态
	 * trash-回收站 1-发布 2-草稿 3-修订
	 * @var array
	 */
	private $status = array('trash'=>0,'public'=>1,''=>2,''=>3);

	/**
	 * 类型
	 * text-文章;file-文件;img-图片;menu-目录
	 * @var array
	 */
	private $type = array('text','file','img','menu');

	public function __construct(&$db,&$comment,$tableNamePost,$tableNameMeta){
		$this->db = $db;
		$this->tableNamePost = $tableNamePost;
		$this->tableNameMeta = $tableNameMeta;
	}
	public function view($id){
	}
	public function viewList($page=1,$max=10,$sort=0,$desc=true){
	}
	public function add($data){
	}
	public function edit($id,$data){
	}
	public function del($id){
	}

	/**
	 * 获取字符串SHA1
	 * SHA1如果是文章，则以文章标题和内容计算。
	 * @param  string $str 字符串
	 * @return string      SHA1
	 */
	private function getSHA1(&$str){
		return sha1($str);
	}

	/**
	 * 计算文件SHA1值
	 * @param  string $src 文件路径
	 * @return string      SHA1
	 */
	private function getFileSHA1($src){
		if(is_file($src) == true){
			return sha1_file($src);
		}
		return false;
	}
}

?>