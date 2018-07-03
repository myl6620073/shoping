function showAttribute()
{
    // 发出ajax请求
    var url = urlProductAttribute;
    var data = {
        attribute_group_id: $('#input-attribute_group_id').val()
    };
    $.get(url, data, function(resp) {}, 'json');
}
// 改变事件发生时, 调用showAttribute()
$('#input-attribute_group_id').change(function() {
    showAttribute();
});
