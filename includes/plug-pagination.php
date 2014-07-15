<?php

/**
 * 页码生成器
 * @author liuzilu <fotomxq@gmail.com>
 * @version 2
 * @package plug
 */

/**
 * 获取页码HTML
 * @param int $url URL
 * @param int $page 当前页数，从1开始
 * @param int $row 总记录数
 * @param int $max 页长
 * @return string 页码HTML
 */
function PlugPaginationQuick($url, $page, $row, $max = 10) {
    $plugPagination = new PlugPagination($url);
    $plugPagination->setMax($max);
    return $plugPagination->output($page, $row);
}

class PlugPagination {

    /**
     * URL
     * @var string 
     */
    private $url;

    /**
     * URL后缀
     * @var string 
     */
    private $urlAppend;

    /**
     * 是否显示页码
     * @var boolean 
     */
    private $showPage = true;

    /**
     * 是否显示下一页按钮
     * @var boolean
     */
    private $showNext = true;

    /**
     * 显示跳到第一页
     * @var boolean 
     */
    private $showFirst = true;

    /**
     * 显示跳到末页
     * @var boolean 
     */
    private $showLast = true;

    /**
     * 是否显示上一页按钮
     * @var boolean 
     */
    private $showPrev = true;

    /**
     * 是否显示当前位置提示
     * @var boolean 
     */
    private $showTip = true;

    /**
     * 显示页码个数
     * @var int 
     */
    private $showPageNum = 5;

    /**
     * 页长
     * @var int 
     */
    private $max = 10;

    /**
     * 简易图标
     * @var array 
     */
    private $icons;

    /**
     * HTML主体
     * @var string 
     */
    private $html = '<div class="pagination"><ul>';

    /**
     * HTML后缀
     * @var string 
     */
    private $htmlAppend = '</ul></div>';

    /**
     * 初始化
     * @param string $url URL
     */
    public function __construct($url) {
        $this->url($url, '');
        $this->setIconsSimple(false);
    }

    /**
     * 获取HTML
     * @param int $page 页数
     * @param int $row 记录数
     * @return string HTML
     */
    public function output($page, $row) {
        $html = $this->html;
        $pageMax = ceil($row / $this->max);
        //第一页
        if ($this->showFirst == true) {
            $urlFirst = $this->url . 1 . $this->urlAppend;
            $html .= $this->getChild($urlFirst, $this->icons[0]);
        }
        //上一页
        if ($this->showPrev == true) {
            $prev = $page - 1;
            if ($prev < 1) {
                $prev = 1;
            }
            $urlPrev = $this->url . $prev . $this->urlAppend;
            $html .= $this->getChild($urlPrev, $this->icons[1]);
        }
        //构建页码
        if ($this->showPage == true) {
            $middle = ceil($this->showPageNum / 2);
            $step = $page - $middle;
            $setpLimit = 0;
            if ($step < 1) {
                $setpLimit = abs(1 - $step);
                $step = 1;
            }
            $pageLeftNum = $step;
            $pageRightNum = $page + $middle + $setpLimit;
            if ($pageRightNum > $pageMax) {
                $pageRightNum = $pageMax;
            }
            for ($i = $pageLeftNum; $i <= $pageRightNum; $i++) {
                $url = $this->url . $i . $this->urlAppend;
                if ($i == $page) {
                    $html .= $this->getChild('#', $page . ' / ' . $pageMax, true, true);
                } else {
                    $html .= $this->getChild($url, $i);
                }
            }
        }
        //下一页
        if ($this->showNext == true) {
            $next = $page + 1;
            if ($next > $pageMax) {
                $next = $pageMax;
            }
            $urlNext = $this->url . $next . $this->urlAppend;
            $html .= $this->getChild($urlNext, $this->icons[2]);
        }
        //末页
        if ($this->showLast == true) {
            $urlLast = $this->url . $pageMax . $this->urlAppend;
            $html .= $this->getChild($urlLast, $this->icons[3]);
        }
        $html .= $this->htmlAppend;
        return $html;
    }

    /**
     * 设置URL
     * @param string $url URL
     * @param string $urlAppend URL后缀
     */
    public function url($url, $urlAppend) {
        $this->url = $url;
        $this->urlAppend = $urlAppend;
    }

    /**
     * 设置页长
     * @param int $max 页长
     */
    public function setMax($max) {
        $this->max = $max;
    }

    /**
     * 获取子元素
     * @param string $url URL
     * @param string $text 文本
     * @param boolean $active 是否激活状态
     * @param boolean $disabled 是否禁用
     * @return string HTML
     */
    private function getChild($url, $text, $active = false, $disabled = false) {
        $html = '<li';
        if ($active == true || $disabled == true) {
            $html .= ' class="';
            if ($active == true) {
                $html .= 'active';
            }
            if ($disabled == true) {
                $html .= ' disabled';
            }
            $html .= '"';
        }
        $html .= '><a href="' . $url . '">' . $text . '</a></li>';
        return $html;
    }

    /**
     * 设定固定标记为简写
     * @param boolean $bool 是否为图标简写，如果不是则设定为中文文字
     */
    private function setIconsSimple($bool) {
        if ($bool == true) {
            $this->icons = array('&laquo;', '<', '>', '»');
        } else {
            $this->icons = array('首页', '上一页', '下一页', '末页');
        }
    }

}

?>
