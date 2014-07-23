/**
 * Label标签组生成控制器
 * 快速生成和实现高级控制
 * 如果发现span不换行，则给dom span添加css : float:left
 */
var label = new Object;
/**
 * 清空DOM并添加标签组
 * @param DOM dom 控制的DOM,如$('#dom')
 * @param array arr 数据数组,如array('title1','title2',...)
 * @param string type 类型,如default/primary/success/info/warning/danger
 */
label.insertArr = function(dom, arr, type) {
    dom.html('');
    for (var i = 0; i < arr.length; i++) {
        label.insert(dom, arr[i], type);
    }
}
/**
 * 向两个DOM组添加可操作转移的标签组
 * @param DOM domA 第一个DOM
 * @param DOM domB 第二个DOM
 * @param array arrA 第一个数据数组
 * @param array arrB 第二个数据数组
 * @param string typeA 第一个类型
 * @param string typeB 第二个类型
 */
label.insertChange = function(domA, domB, arrA, arrB, typeA, typeB) {
    label.insertArr(domA, arrA, typeA);
    label.insertArr(domB, arrB, typeB);
    domA.children('span').click(function() {
        label.change($(this), domB, typeB, typeA);
    });
    domB.children('span').click(function() {
        label.change($(this), domA, typeA, typeB);
    });
}
/**
 * 插入数据并绑定选择事件
 * 对应span会添加"data-select='0' / '1'"属性
 * @param DOM dom 控制的DOM,如$('#dom')
 * @param array arr 数据数组,如array('title1','title2',...)
 * @param string unSelectType 未选择类型
 * @param string selectType 选择后类型
 */
label.insertSelect = function(dom, arr, unSelectType, selectType) {
    dom.html('');
    for (var i = 0; i < arr.length; i++) {
        dom.append('<span class="label label-' + unSelectType + '" data-select="0" style="cursor:pointer;">' + arr[i] + '</span> ');
    }
    dom.children('span').click(function() {
        if ($(this).attr('data-select') === '0') {
            $(this).attr('data-select', '1');
            $(this).removeClass('label-' + unSelectType);
            $(this).addClass('label-' + selectType);
        } else {
            $(this).attr('data-select', '0');
            $(this).removeClass('label-' + selectType);
            $(this).addClass('label-' + unSelectType);
        }
    });
}
/**
 * 向DOM添加Label
 * @param DOM dom 控制DOM
 * @param string str 标签内容
 * @param string type 标签类型 
 */
label.insert = function(dom, str, type) {
    dom.append('<span class="label label-' + type + '" style="cursor:pointer;">' + str + '</span> ');
}
/**
 * 转移标签事件
 * @param DOM domOld 原DOM-SPAN
 * @param DOM domNew 转移到控制DOM
 * @param string type 类型
 */
label.change = function(domOld, domNew, typeNew, typeOld) {
    label.insert(domNew, domOld.html(), typeNew);
    domNew.children('span').last().click(function() {
        label.change($(this), domOld.parent(), typeOld, typeNew);
    });
    domOld.hide();
}
/**
 * 获取已选标签组-change
 * @param DOM dom 控制DOM
 * @returns array 数据数组
 */
label.getChange = function(dom) {
    var doms = dom.children('span:visible');
    var res = new Array();
    doms.each(function(k, v) {
        res.push($(this).html());
    });
    return res;
}
/**
 * 获取已选标签组-select
 * @param DOM dom 控制DOM
 * @returns array 数据数组
 */
label.getSelect = function(dom) {
    var doms = dom.children('span[data-select="1"]');
    var res = new Array();
    doms.each(function(k, v) {
        res.push($(this).html());
    });
    return res;
}