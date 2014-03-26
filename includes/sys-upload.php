<?php
/**
 * 上传文件处理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */

class SysUpload{
	/**
	 * POST对象
	 * @var SysPost
	 */
	private $post;

	/**
	 * 初始化
	 * @param SysPost $post POST对象
	 */
	public function __construct(&$post){
		$this->post = $post;
	}
	
	public function upload($uploadfile){
		return false;
	}
	public function download(){
		
	}

	/**
	 * 转移上传文件
	 * @param  string $uploadfile 上传文件路径
	 * @param  string $dest       转移到路径
	 * @return boolean             是否成功
	 */
	private function moveFile($uploadfile,$dest){
		return move_uploaded_file($uploadfile, $dest);
	}

	/**
	 * 计算文件SHA1
	 * @param  string $src 文件路径
	 * @return string      SHA1值
	 */
	private function fileSha1($src){
		return sha1_file($src);
	}
}
?>