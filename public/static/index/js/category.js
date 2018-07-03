/**
 * Created by THINK on 2017/9/8.
 */

function categoryInit()
{
    var url = urlCategoryInit;
    var data = {
        type: 'nested',
        maxDeep: 2
    };
    $.get(url, data, function(resp) {
        if (resp.error) {
            console.log(resp.errorInfo);
            return ;
        }

        // 没有错误, 展示数据

        // 遍历一级分类
        $.each(resp.data, function(i, one) {
            var html = '<li class="parent ';
            html += one.children && one.children.length>0 ? 'with-sub-menu' : '"';
            html += '">';
            html += '<a href="">'+one.title+'</a>';
            // 考虑2级分类
            if(one.children && one.children.length>0) {
                html += '<div class="open-sub-menu">+</div>';
                html += '<ul class="sub-menu">';
                $.each(one.children, function(ii, two) {
                    html += '<li>';
                    html += '<a href="">'+two.title+'</a>';
                    html += '</li>';
                });
                html += '</ul>';
            }
            html += '</li>';

            $('#ul-menu').append(html);
        });

    }, 'json');

}

$(function() {
    categoryInit();
});