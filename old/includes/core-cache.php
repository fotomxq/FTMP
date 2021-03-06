<?php

/**
 * 缓冲处理器
 * 缓冲相关变量或值。
 * 
 * @author liuzilu <fotomxq@gmail.com>
 * @version 8
 */
class CoreCache {

    /**
     * 是否开启缓冲器
     * @var boolean
     */
    private $cacheOpen = true;

    /**
     * 缓冲失效时间 (s)
     * @var int
     */
    private $limitTime = 1296000;

    /**
     * 缓冲目录
     * @var string
     */
    private $cacheDir;

    /**
     * 路径分隔符
     * @var string
     */
    private $ds = DIRECTORY_SEPARATOR;

    /**
     * 缓冲文件后缀名
     * @var string
     */
    private $suffix = '.cache';

    /**
     * 初始化
     * @param boolean $cacheOpen   是否开启缓冲
     * @param int $limitTime 缓冲失效时间 (s)
     * @param string $cacheDir 缓冲目录
     */
    public function __construct($cacheOpen, $limitTime, $cacheDir) {
        $this->cacheOpen = $cacheOpen;
        $this->limitTime = $limitTime;
        $this->cacheDir = $cacheDir;
        if (is_dir($cacheDir) != true) {
            mkdir($cacheDir, 0777, true);
        }
    }

    /**
     * 根据一组数据生成标示符
     * @param string $name 前缀名称
     * @param array $arr 数据数组，不接收子数据为数组的情况 eg:array(int a,boolean b,string c)
     * @return string
     */
    public function getName($name, $arr = '') {
        if ($arr) {
            foreach ($arr as $v) {
                $vStr;
                if (is_int($v) || is_string($v)) {
                    $vStr = $v;
                }
                if (is_bool($v)) {
                    $vStr = $v ? 'TRUE' : 'FALSE';
                }
                $name .= '-' . $vStr;
            }
        } else {
            return $name;
        }
    }

    /**
     * 获取一个缓冲值
     * 如果发现缓冲失效，则删除缓冲文件。
     * @param  string $name 标识码
     * @return string       值
     */
    public function get($name) {
        if ($this->cacheOpen != true) {
            return false;
        }
        $src = $this->getSrc($this->getNameSha1($name));
        if (is_file($src) != true) {
            return false;
        }
        if ($this->checkTime($src) == true) {
            return $this->loadFile($src);
        } else {
            $this->clear($name);
        }
        return false;
    }

    /**
     * 设定缓冲
     * @param string $name  标识名
     * @param string $value 值
     * @return boolean 是否成功
     */
    public function set($name, $value) {
        $src = $this->getSrc($this->getNameSha1($name));
        return $this->saveFile($src, $value);
    }

    /**
     * 缓冲缩略图
     * <p>如果存在则输出，否则生成再输出。最终输出jpg文件。</p>
     * @param  string $src 文件路径
     * @param  int $w 宽度
     * @param  int $h 高度
     * @return string 缩略图缓冲文件路径
     */
    public function img($src, $w, $h) {
        if (!is_file($src)) {
            return false;
        }
        $fileSha1 = sha1_file($src);
        $fileType = pathinfo($src, PATHINFO_EXTENSION);
        //生成缓冲文件路径
        $childDir = $w . $h;
        $cacheSrc = $this->getSrc($fileSha1, '.jpg', $childDir);
        if (is_file($cacheSrc)) {
            return $cacheSrc;
        } else {
            //压缩图片
            $img = null;
            switch ($fileType) {
                case 'jpg':
                    $img = @imagecreatefromjpeg($src);
                    break;
                case 'jpeg':
                    $img = @imagecreatefromjpeg($src);
                    break;
                case 'png':
                    $img = @imagecreatefrompng($src);
                    break;
            }
            if ($img) {
                $newImg = PlugImgScale($img, $w, $h);
                imagedestroy($img);
                if ($newImg) {
                    //保存图片
                    if (imagejpeg($newImg, $cacheSrc, 100)) {
                        imagedestroy($newImg);
                        return $cacheSrc;
                    }
                }
            }
        }
        return '';
    }

    /**
     * 清理图片缓冲
     * @return boolean 是否成功
     */
    public function clearImg() {
        $src = $this->cacheDir . $this->ds . '*';
        $fileList = glob($src);
        if ($fileList) {
            foreach ($fileList as $v) {
                if (is_dir($v)) {
                    if (!CoreFile::deleteDir($v)) {
                        return false;
                    }
                }
                if (is_file($v)) {
                    if (!unlink($v)) {
                        return false;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 清理缓冲文件
     * @param  string $name 标识名 (可选)
     * @return boolean      是否成功
     */
    public function clear($name = null) {
        if ($name == null) {
            $s = $this->getSrc('*');
            $fileList = glob($s);
            if ($fileList) {
                foreach ($fileList as $v) {
                    if (is_file($v)) {
                        unlink($v);
                    } else if (is_dir($v)) {
                        CoreFile::deleteDir($v);
                    }
                }
            }
            return true;
        } else {
            $src = $this->getSrc($this->getNameSha1($name));
            if (is_file($src) == true) {
                return unlink($src);
            }
            return true;
        }
    }

    /**
     * 保存文件
     * @param  string $src  文件路径
     * @param  string $data 数据
     * @return boolean		是否成功
     */
    private function saveFile($src, $data) {
        return file_put_contents($src, $data);
    }

    /**
     * 读取文件
     * @param  string $src  文件路径
     * @return string		数据
     */
    private function loadFile($src) {
        return file_get_contents($src);
    }

    /**
     * 检查是否超过时间限制
     * @param  string $src 文件路径
     * @return boolean      是否成功
     */
    private function checkTime($src) {
        $fileTime = filemtime($src);
        if (!$fileTime) {
            return false;
        }
        $nowTime = time();
        $t = (int) $nowTime - (int) $fileTime;
        if ($t < $this->limitTime) {
            return true;
        }
        return false;
    }

    /**
     * 加密标识
     * @param  string $name 标识
     * @return string       标识SHA1值
     */
    private function getNameSha1($name) {
        return sha1($name);
    }

    /**
     * 获取文件全部路径
     * @param  string $name 文件名称
     * @param  string $type 文件类型
     * @param  string $childDir 细分目录
     * @return string       文件路径
     */
    private function getSrc($name, $type = null, $childDir = null) {
        $dir = $this->cacheDir . $this->ds;
        if ($childDir) {
            $dir .= $childDir . $this->ds;
        }
        $firstStr = substr($name, 0, 2);
        $dir .= $firstStr;
        if (!CoreFile::newDir($dir)) {
            return false;
        }
        $suffix;
        if ($type) {
            $suffix = $type;
        } else {
            $suffix = $this->suffix;
        }
        return $dir . $this->ds . $name . $suffix;
    }

}

?>