<?php

/**
 * IP操作类
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */
class CoreIP {

    /**
     * Ban列表
     * @var array 
     */
    private $banList;

    /**
     * 白名单
     * @var array 
     */
    private $whiteList;

    /**
     * 地址数据库文件
     * @var string 
     */
    private $addressDataSrc;
    
    /**
     * IP类型 eg: 4 | 6
     * @var int 
     */
    private $ipType;

    /**
     * IP地址
     * @var type 
     */
    public $ip;

    /**
     * 初始化
     * @param string $ban 黑名单字符串，逗号分隔 eg:127.0.0.1,192.168.1.1,e8:12...
     * @param string $white 白名单，逗号分隔
     * @param string $addressDataSrc 地址数据库文件路径
     */
    public function __construct($ban, $white, $addressDataSrc = '') {
        $this->ip = '';
        if ($ban) {
            $this->banList = explode(',', $ban);
        } else {
            $this->banList = array();
        }
        if ($white) {
            $this->whiteList = explode(',', $white);
        } else {
            $this->whiteList = array();
        }
        $this->addressDataSrc = $addressDataSrc;
        $this->getIP();
    }

    /**
     * 判断Ip是否拉黑
     * @param string $ip Ip地址
     * @return boolean 是否拉黑
     */
    public function isBan($ip = null) {
        return $this->isExistIP($this->banList, $ip);
    }

    /**
     * 判断Ip是否在白名单内
     * @param string $ip Ip地址
     * @return boolean 是否存在
     */
    public function isWhite($ip = null) {
        return $this->isExistIP($this->whiteList, $ip);
    }

    /**
     * 获取黑名单数据
     * @param string $addIP 添加一个Ip
     * @return string 黑名单数据
     */
    public function getBanList($addIP = null) {
        return $this->getList($this->banList, $addIP);
    }

    /**
     * 获取白名单数据
     * @param string $addIP
     * @return string 白名单数据
     */
    public function getWhiteList($addIP = null) {
        return $this->getList($this->whiteList, $addIP);
    }

    /**
     * 获取当前Ip
     * @return string
     */
    public function getIP() {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "0.0.0.0";
        }
        $this->ip = $ip;
        if (substr_count($ip, '.') > 3) {
            $this->ipType = 4;
        } else {
            $this->ipType = 6;
        }
        return $ip;
    }

    /**
     * 获取Ip物理地址
     * <p>只能判断Ip v4，且必须设定$addressDataSrc变量</p>
     * @param string $ip IP地址
     * @return string IP真实地址
     */
    public function getIPAddress($ip) {
        if ($this->addressDataSrc == '') {
            return '';
        }
        $addressDataSrc = $this->addressDataSrc;
        if (!$fd = @fopen($addressDataSrc, 'rb')) {
            return 'IP date file not exists or access denied';
        }
        $ip = explode('.', $ip);
        $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];
        $DataBegin = fread($fd, 4);
        $DataEnd = fread($fd, 4);
        $ipbegin = implode('', unpack('L', $DataBegin));
        if ($ipbegin < 0)
            $ipbegin += pow(2, 32);
        $ipend = implode('', unpack('L', $DataEnd));
        if ($ipend < 0)
            $ipend += pow(2, 32);
        $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
        $BeginNum = 0;
        $EndNum = $ipAllNum;
        while ($ip1num > $ipNum || $ip2num < $ipNum) {
            $Middle = intval(($EndNum + $BeginNum) / 2);
            fseek($fd, $ipbegin + 7 * $Middle);
            $ipData1 = fread($fd, 4);
            if (strlen($ipData1) < 4) {
                fclose($fd);
                return 'System Error';
            }
            $ip1num = implode('', unpack('L', $ipData1));
            if ($ip1num < 0)
                $ip1num += pow(2, 32);
            if ($ip1num > $ipNum) {
                $EndNum = $Middle;
                continue;
            }
            $DataSeek = fread($fd, 3);
            if (strlen($DataSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $DataSeek = implode('', unpack('L', $DataSeek . chr(0)));
            fseek($fd, $DataSeek);
            $ipData2 = fread($fd, 4);
            if (strlen($ipData2) < 4) {
                fclose($fd);
                return 'System Error';
            }
            $ip2num = implode('', unpack('L', $ipData2));
            if ($ip2num < 0)
                $ip2num += pow(2, 32);
            if ($ip2num < $ipNum) {
                if ($Middle == $BeginNum) {
                    fclose($fd);
                    return 'Unknown';
                }
                $BeginNum = $Middle;
            }
        }
        $ipFlag = fread($fd, 1);
        if ($ipFlag == chr(1)) {
            $ipSeek = fread($fd, 3);
            if (strlen($ipSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $ipSeek = implode('', unpack('L', $ipSeek . chr(0)));
            fseek($fd, $ipSeek);
            $ipFlag = fread($fd, 1);
        }
        if ($ipFlag == chr(2)) {
            $AddrSeek = fread($fd, 3);
            if (strlen($AddrSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $ipFlag = fread($fd, 1);
            if ($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if (strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return 'System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr2 .= $char;
            $AddrSeek = implode('', unpack('L', $AddrSeek . chr(0)));
            fseek($fd, $AddrSeek);
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;
        } else {
            fseek($fd, -1, SEEK_CUR);
            while (($char = fread($fd, 1)) != chr(0))
                $ipAddr1 .= $char;

            $ipFlag = fread($fd, 1);
            if ($ipFlag == chr(2)) {
                $AddrSeek2 = fread($fd, 3);
                if (strlen($AddrSeek2) < 3) {
                    fclose($fd);
                    return 'System Error';
                }
                $AddrSeek2 = implode('', unpack('L', $AddrSeek2 . chr(0)));
                fseek($fd, $AddrSeek2);
            } else {
                fseek($fd, -1, SEEK_CUR);
            }
            while (($char = fread($fd, 1)) != chr(0)) {
                $ipAddr2 .= $char;
            }
        }
        fclose($fd);
        if (preg_match('/http/i', $ipAddr2)) {
            $ipAddr2 = '';
        }
        $ipaddr = "$ipAddr1 $ipAddr2";
        $ipaddr = preg_replace('/CZ88.Net/is', '', $ipaddr);
        $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
        $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
        if (preg_match('/http/i', $ipaddr) || $ipaddr == '') {
            $ipaddr = 'Unknown';
        }
        $ipaddr = iconv('gbk', 'utf-8//IGNORE', $ipaddr);
        if ($ipaddr != '  ')
            return $ipaddr;
        else
            $ipaddr = '未知区域';
        return $ipaddr;
    }

    /**
     * 判断Ip是否在列表数组中出现
     * @param array $list 列表数组
     * @param string $ip IP地址
     * @return boolean 是否出现
     */
    private function isExistIP(&$list, $ip = null) {
        if ($ip == null) {
            if ($this->ip == '') {
                $ip = $this->getIP();
            } else {
                $ip = $this->ip;
            }
        }
        return in_array($ip, $list);
    }

    /**
     * 获取列表数据
     * @param array $list 列表数组
     * @param string $addIP 添加Ip地址
     * @return array 列表数组
     */
    private function getList(&$list, $addIP = null) {
        if ($addIP == null) {
            return implode(',', $list);
        } else {
            return implode(',', $this->addIP($list, $addIP));
        }
    }

    /**
     * 为列表添加一个Ip地址
     * @param array $list 列表数组
     * @param string $ip Ip地址
     * @return array 新的数组
     */
    private function addIP(&$list, $ip = null) {
        if ($ip == null) {
            if ($this->ip == '') {
                $this->getIP();
            }
            $ip = $this->ip;
        }
        $list[] = $ip;
        return $list;
    }

}

?>
