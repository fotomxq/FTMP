<?php

/**
 * APP-PEX2
 * @author liuzilu <fotomxq.me>
 * @date    2014-08-05 21:39:00
 * @version 2
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
    private $tagFields = array('id', 'name', 'class');

    /**
     * 文件数据表字段
     * @var array 
     */
    private $fxFields = array('id', 'parent', 'title', 'type', 'class', 'sort', 'src', 'name', 'sha1', 'create_time', 'visit_time', 'content');

    /**
     * 文件和标签关系数据表字段
     * @var array
     */
    private $txFields = array('id', 'file_id', 'tag_id');

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
     * 缓冲处理器
     * @var CoreCache 
     */
    private $cache;

    /**
     * 初始化
     * @param CoreDB $db            数据库对象
     * @param string $dataFolderSrc 文件数据目录路径
     * @param CoreLog $log 日志对象
     * @param CoreCache $cache 缓冲处理器
     */
    public function __construct(&$db, $dataFolderSrc, &$log, &$cache) {
        $this->ds = DIRECTORY_SEPARATOR;
        $this->db = $db;
        $this->dataFolderSrc = $dataFolderSrc;
        $this->dataFolderFileSrc = $dataFolderSrc . $this->ds . 'file';
        $this->dataFolderTrashSrc = $dataFolderSrc . $this->ds . 'trash';
        $this->log = $log;
        $this->cache = $cache;
    }

    public function getFileList($page, $max, $sort, $desc) {
        
    }

    public function getFile($target) {
        
    }

    public function getTagList($type) {
        
    }

    /**
     * 获取标签信息
     * @param int $tagID 标签ID
     * @return array 数据数组
     */
    public function getTag($tagID) {
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attr = array(':id' => array($tagID, PDO::PARAM_INT));
        $res = $this->db->sqlSelect($this->fxTableName, $this->fxFields, $where, $attr);
        return $res;
    }

    public function getTx($target, $targetType = 'file') {
        
    }

    public function releaseReady() {
        
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