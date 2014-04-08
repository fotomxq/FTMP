<?php
/**
 * 体重记录首页
 * @author fotomxq <fotomxq.me>
 * @version 5
 * @package app-weight-page
 */
//引用全局
require('glob.php');
//引用顶部栏目
require(DIR_APP_TEMPLATE . DS . 'header.php');
//引用菜单
require(DIR_APP_TEMPLATE . DS . 'menu.php');
?>
<div class="container marketing container-fixed">
    <div id="contentSet">
        <h2 class="page-header" id="urlSet"><span class="glyphicon glyphicon-pushpin"></span> 设置</h2>
        <div class="row row-fixed">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-addon">日期</span>
                    <input class="form-control" type="text" data-date-format="yyyy-mm-dd" id="datetimepicker">
                    <span class="input-group-btn">
                        <a class="btn btn-default" href="#setDateRepeat"><span class="glyphicon glyphicon-repeat"></span></a>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">体重</span>
                    <input id="weight" class="form-control" type="text" placeholder="0.00">
                    <span class="input-group-addon">KG</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">体脂</span>
                    <input id="fat" class="form-control" type="text" placeholder="0">
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>
        <div class="row row-fixed">
            <div class="col-lg-1">
                <label>
                    <div class="icheckbox"><input type="checkbox" id="tagDinner"> 吃饭</div>
                </label>
            </div>
            <div class="col-lg-1">
                <label>
                    <div class="icheckbox"><input type="checkbox" id="tagSport"> 运动</div>
                </label>
            </div>
            <div class="col-lg-1">
                <label>
                    <div class="icheckbox"><input type="checkbox" id="tagSleep"> 睡觉</div>
                </label>
            </div>
            <div class="col-lg-1">
                <label>
                    <div class="icheckbox"><input type="checkbox" id="tagToilet"> 厕所</div>
                </label>
            </div>
            <div class="col-lg-1">
                <label>
                    <div class="icheckbox"><input type="checkbox" id="tagSick"> 生病</div>
                </label>
            </div>
            <div class="col-lg-1">
                <label>
                    <div class="icheckbox"><input type="checkbox" id="tagAlcohol"> 饮酒</div>
                </label>
            </div>
        </div>
        <div class="row row-fixed">
            <div class="col-lg-5">
                <textarea id="note" class="form-control" rows="3" placeholder="Note..."></textarea>
            </div>
        </div>
        <div class="row row-fixed">
            <div class="col-lg-3">
                <a class="btn btn-default" href="#setDataSubmit"><span class="glyphicon glyphicon-plus"></span> 记录体重</a>
            </div>
        </div>
    </div>
    <div id="contentChart">
        <h2 class="page-header" id="urlChart"><span class="glyphicon glyphicon-stats"></span> 图表</h2>
        <div class="row row-fixed">
            <label><div class="icheckbox"><input type="radio" id="chartWeight" name="chartSelect"> 体重</div></label>
            <label><div class="icheckbox"><input type="radio" id="chartFat" name="chartSelect"> 体脂 </div></label>
            <div class="btn-group">
                <a class="btn btn-default" href="#chartDay"><span class="glyphicon glyphicon-credit-card"></span> 最近</a>
                <a class="btn btn-default" href="#chartWeek"><span class="glyphicon glyphicon-credit-card"></span> 本周</a>
                <a class="btn btn-default" href="#chartMonth"><span class="glyphicon glyphicon-calendar"></span> 本月</a>
                <a class="btn btn-default" href="#chartYear"><span class="glyphicon glyphicon-calendar"></span> 年</a>
            </div>
        </div>
        <div class="row">
            <canvas id="weightChart" width="500" height="300"></canvas>
        </div>
    </div>
</div>
<?php
//引用底部
require(DIR_APP_TEMPLATE . DS . 'footer.php');
?>