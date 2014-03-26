<?php

/**
 * 缓冲器
 * <p>需要扩展 : CoreFile</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package extend
 * @tudo 该文件作废，需要根据cache重写.
 */
class ExtendCache {

    /**
     * 缓冲目录
     * @var string 
     */
    private $cacheDir;

    /**
     * 过期时间 ( Unix时间戳 )
     * @var int 
     */
    private $limitTime;

    /**
     * 缓冲器开关
     * @var boolean 
     */
    private $cacheOn;

    /**
     * 初始化
     * @param string $cacheDir 缓冲目录
     * @param int $limitTime 过期时间 ( Unix时间戳 )
     * @param boolean $cacheOn 缓冲器开关
     */
    public function __construct($cacheDir, $limitTime, $cacheOn) {
        $this->cacheDir = $cacheDir;
        $this->limitTime = time() + (int) $limitTime;
        $this->cacheOn = $cacheOn;
    }

    /**
     * 获取缓冲
     * <p>注意匹配结果时，请用 !==false 判断返回失败；如果没有内容，则返回空字符串。</p>
     * @param string $name 标识
     * @param boolean $arrBool 是否输出为数组
     * @return mixed 文件数据，如果缓冲失效或不存在，则返回false
     */
    public function get($name, $arrBool = false) {
        $sha1 = sha1($name);
        $fileSrc = $this->getFileName($sha1);
        if ($this->isReady($fileSrc) == true) {
            $res = $this->getFile($fileSrc);
            return json_decode($res, $arrBool);
        }
        return false;
    }

    /**
     * 保存变量
     * @param string $name 名称
     * @param mixed $values 值
     * @return boolean 是否成功
     */
    public function save($name, $values) {
        $sha1 = sha1($name);
        $fileSrc = $this->getFileName($sha1);
        $value = json_encode($values);
        return $this->saveFile($fileSrc, $value);
    }

    /**
     * 清空缓冲器
     */
    public function clear($name = null) {
        if ($name === null) {
            $search = $this->getFileName('*');
            $fileList = CoreFile::searchDir($search);
            if ($fileList) {
                foreach ($fileList as $v) {
                    if ($this->isFile($v) == true) {
                        CoreFile::deleteFile($v);
                    }
                }
            }
        } else {
            $sha1 = sha1($name);
            $fileSrc = $this->getFileName($sha1);
            if ($this->isFile($fileSrc) == true) {
                CoreFile::deleteFile($fileSrc);
            }
        }
    }

    /**
     * 文件是否可用
     * @param string $src 文件路径
     * @return boolean 是否可用
     */
    private function isReady($src) {
        if ($this->isFile($src) == true) {
            $fileTime = filectime($src);
            if ($fileTime > 0 && $fileTime <= $this->limitTime) {
                return true;
            }
        }
        return false;
    }

    /**
     * 文件是否存在
     * @param string $src 文件路径
     * @return boolean 文件是否存在
     */
    private function isFile($src) {
        return CoreFile::isFile($src);
    }

    /**
     * 保存文件数据
     * @param string $src 文件路径
     * @param string $data 数据
     * @return boolean 是否成功
     */
    private function saveFile($src, $data) {
        return CoreFile::saveFile($src, $data);
    }

    /**
     * 获取文件数据
     * @param string $src 文件路径
     * @return string 数据内容
     */
    private function getFile($src) {
        return CoreFile::loadFile($src);
    }

    /**
     * 获取文件路径
     * @param string $srcSha1 文件SHA1
     * @return string 文件路径
     */
    private function getFileName($sha1) {
        return $this->cacheDir . CoreFile::$ds . $sha1;
    }

}

?>
