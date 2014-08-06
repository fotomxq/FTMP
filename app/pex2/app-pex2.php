<?php

/**
 * APP-PEX2
 * @author liuzilu <fotomxq.me>
 * @date    2014-08-05 21:39:00
 * @version 1
 */
class AppPex2 {

    /**
     * 标签数据表
     * @var string 
     */
    private $tagTableName = 'app_pex_tag';

    /**
     * 文件数据表名称
     * @var string
     */
    private $fxTableName = 'app_pex_fx';

    /**
     * 文件和标签数据表
     * @var string
     */
    private $txTableName = 'app_pex_tx';

    /**
     * 数据库对象
     * @var CoreDB 
     */
    private $db;

    /**
     * 标签数据表字段
     * @var array
     */
    private $tagFields = array('id', 'tag_name', 'tag_type');

    /**
     * 文件数据表字段
     * @var array 
     */
    private $fxFields = array('id', 'fx_title', 'fx_name', 'fx_parent', 'fx_size', 'fx_type', 'fx_sha1', 'fx_src', 'fx_create_time', 'fx_visit_time', 'fx_content');

    /**
     * 文件和标签关系数据表字段
     * @var array
     */
    private $txFields = array('id', 'file_id', 'tag_id', 'tx_type');

    /**
     * 文件和标签关系表类型
     * @var array 
     */
    private $txType = array('file', 'folder');

    /**
     * 日志对象
     * @var CoreLog 
     */
    private $log;

    /**
     * 类型
     * key-键值,用于tag表等类型标记 ; folder-对应文件夹ID ; title-名称
     * @var array 
     */
    public $pexType = array(
        'photo' => array('key' => 'photo', 'folder' => 1, 'title' => '照片', 'type' => array('jpg', 'png', 'gif', 'jpeg')),
        'movie' => array('key' => 'movie', 'folder' => 2, 'title' => '影片', 'type' => array('mp4')),
        'cartoon' => array('key' => 'cartoon', 'folder' => 3, 'title' => '漫画', 'cartoon' => array('jpg', 'png', 'jpeg')),
        'txt' => array('key' => 'txt', 'folder' => 4, 'title' => '文本', 'txt' => array('txt'))
    );

    /**
     * 文件数据目录路径
     * @var string
     */
    private $dataFolderSrc;

    /**
     * 文件数据目录
     * @var string
     */
    private $dataFolderFileSrc;

    /**
     * 缓冲图片目录
     * @var string
     */
    private $dataFolderCacheImgsSrc;

    /**
     * 等待发布文件目录
     * @var string
     */
    private $dataFolderTransferSrc;

    /**
     * 垃圾箱目录
     * @var string 
     */
    private $dataFolderTrashSrc;

    /**
     * 文件路径分隔符
     * @var string 
     */
    private $ds;

    /**
     * 初始化
     * @param CoreDB $db            数据库对象
     * @param string $dataFolderSrc 文件数据目录路径
     * @param CoreLog $log 日志对象
     */
    public function __construct(&$db, $dataFolderSrc, &$log) {
        $this->db = $db;
        $this->dataFolderSrc = $dataFolderSrc;
        $this->dataFolderFileSrc = $dataFolderSrc . DS . 'file';
        $this->dataFolderCacheImgsSrc = $dataFolderSrc . DS . 'imgs';
        $this->dataFolderTransferSrc = $dataFolderSrc . DS . 'transfer';
        $this->dataFolderTrashSrc = $dataFolderSrc . DS . 'trash';
        $this->log = $log;
        $this->ds = DIRECTORY_SEPARATOR;
    }

    public function getFileList($page, $max, $sort, $desc) {
        
    }

    public function getFile($target) {
        
    }

    public function getTagList($type) {
        
    }

    public function getTag($tagID) {
        
    }

    public function getTx($target, $targetType = 'file') {
        
    }
    
    public function releaseReady(){
        
    }

    public function release($src, $tags) {
        
    }

    public function releaseFolder($src, $tags) {
        
    }

    public function trash($src) {
        
    }

    public function setFileTags($fileID, $tags) {
        
    }

    private function addTag($tagName, $typeKey) {
        
    }

    private function editTag($tagID, $tagName, $typeKey) {
        
    }

    private function deleteTag($tagID) {
        
    }

    public function setTypeTags($typeKey, $tags) {
        
    }

    private function addTypeTag($fileID, $tagID, $typeKey) {
        
    }

    private function editTypeTag($id, $fileID, $tagID, $typeKey) {
        
    }

    private function deleteTypeTag($id) {
        
    }

}

?>