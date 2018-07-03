function shopInit()
{
    var url = urlShopInit;
    $.get(url, function(resp) {
        $('#span-telphone').text(resp.shop.telphone);
    }, 'json');
}

function memberInit()
{
    $.get(urlMemberInit, function(resp) {
        if (resp.auth) {
            $('#member-operate-list li.non-member').hide();
            $('#member-operate-list li.has-member').show();
            $('#member-center-title').text(resp.member.name || resp.member.email);
        } else {
            $('#member-operate-list li.has-member').hide();
            $('#member-operate-list li.non-member').show();
        }
    }, 'json');
}
$(function() {
    // 初始化商店信息
    shopInit();
    // 初始化会员信息
    memberInit();
});
