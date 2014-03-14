<?php

/**
 * 反馈信息处理包
 * <p>需要额外的扩展 : CoreHeader</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package extend
 */
class ExtendFeedback {

    /**
     * 输出反馈值
     * @param string $type 类型
     * @param mixed $data 数据
     */
    public function output($type = 'url', $data = null) {
        switch ($type) {
            case 'url':
                if (is_string($data) == true) {
                    $this->outputURL($data);
                }
                break;
            case 'html':
                if (is_string($data) == true) {
                    $this->outputURL($data);
                }
                break;
            case 'json':
                $this->outputJSON($data);
                break;
        }
    }

    /**
     * 跳转URL
     * @param string $url URL
     */
    private function outputURL($url) {
        CoreHeader::toURL($url);
    }

    /**
     * 输出HTML
     * @param string $str 输出字符串
     */
    private function outputHTML($str) {
        CoreHeader::noCache();
        CoreHeader::toPage();
        die($str);
    }

    /**
     * 输出JSON
     * @param mixed $data 数据变量
     */
    private function outputJSON($data) {
        CoreHeader::noCache();
        CoreHeader::toJson();
        die(json_encode($data));
    }

}

?>
