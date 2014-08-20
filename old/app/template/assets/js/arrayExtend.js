/**
 * 数组扩展
 */
var arrayExtend = new Object;
/**
 * 计算两个数组差集
 * 以第一个数组为准进行计算，如果在第一个数组出现则去掉
 */
arrayExtend.diff = function(arrA, arrB) {
    var res = new Array();
    if (arrA && !arrB) {
        return arrA;
    }
    if (!arrA) {
        return res;
    }
    if (arrA && arrB) {
        for (var i = 0; i < arrA.length; i++) {
            res.push(arrA[i]);
        }
        for (var i = 0; i < arrB.length; i++) {
            var f = arrA.indexOf(arrB[i]);
            if (f > -1) {
                res.splice(f, 1);
            }
        }
    }
    return res;
}