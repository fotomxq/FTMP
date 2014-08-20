<?php

/**
 * 用户输入过滤器
 * @author liuzilu <fotomxq@gmail.com>
 * @version 2
 * @package core
 */
class CoreFilter {

    /**
     * 过滤整数
     * @param int $int 数字
     * @return int 过滤后数字
     */
    public function getInt($int) {
        return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * 过滤email
     * @param string $str 邮箱地址
     * @return string 过滤后字符串
     */
    public function getEmail($str, $len = null) {
        $res = $str;
        if ($len) {
            $res = $this->getSubStr($res, $len);
        }
        $res = filter_var($res, FILTER_VALIDATE_EMAIL);
        return $res;
    }

    /**
     * 过滤URL
     * @param string $str URL
     * @return string 过滤后字符串
     */
    public function getURL($str, $len = null) {
        $res = $str;
        if ($len) {
            $res = $this->getSubStr($res, $len);
        }
        $res = filter_var($res, FILTER_VALIDATE_URL);
        return $res;
    }

    /**
     * 检查字符串
     * @param string $str 字符串
     * @param int $min 最短
     * @param int $max 最长
     * @return boolean 是否通过
     */
    public function isString($str, $min, $max) {
        $strlen = $this->getStrLen($str);
        if ($strlen >= $min && $strlen <= $max) {
            if (filter_var($str)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 过滤字符串
     * @param string $str 字符串
     * @param int $length 长度
     * @param int $start 起始
     * @param boolean $nohtml 是否去HTML标签
     * @param boolean $stripTag 是否去特殊字符
     * @return string 过滤后的字符串
     */
    public function getString($str, $length, $start = 0, $nohtml = false, $stripTag = false) {
        $res = $this->getSubStr($str, $length, $start);
        if ($res) {
            $res = filter_var($res);
            if ($stripTag == true) {
                $res = strip_tags($res);
            } else {
                if ($nohtml == true) {
                    $res = htmlspecialchars($res);
                }
            }
            return $res;
        }
        return '';
    }

    /**
     * 截取字符串
     * @param string $string 字符串
     * @param int $sublen 长度
     * @param int $start 起始位置
     * @param string $code 编码类型
     * @return string 截取后的字符串
     */
    private function getSubStr($string, $sublen, $start = 0, $code = 'UTF-8') {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);
            if (count($t_string[0]) - $start > $sublen)
                return join('', array_slice($t_string[0], $start, $sublen)) . "...";
            return join('', array_slice($t_string[0], $start, $sublen));
        }
        else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';

            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr.= substr($string, $i, 2);
                    } else {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129)
                    $i++;
            }
            if (strlen($tmpstr) < $strlen)
                $tmpstr.= "...";
            return $tmpstr;
        }
    }

    /**
     * 获取UTF8字符串长度
     * @param string $str 字符串
     * @param string $encoding 编码
     * @return int 长度
     */
    private function getStrLen($str, $encoding = 'UTF-8') {
        return mb_strlen($str, $encoding);
    }

}

?>
