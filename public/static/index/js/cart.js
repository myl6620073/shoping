// 前端的购物车对象

// 立即执行的函数，生成一个对象
+function() {
    // 添加
    function add(options)
    {
        var url = config.site.urlRoot + 'cart-add.html';
        var data = {
            product_id: options.product_id,
            buy_quantity: options.buy_quantity
        };
        $.post(url, data, function(resp) {
            if (resp.error) {
                // 添加失败
                if (options.error) {
                    options.error();
                }
            } else {
                // 添加成功
                if (options.success) {
                    options.success();
                }
            }
        });
    }
    // 迷你购物车展示
    function minicartRefresh()
    {
        // 刷新迷你购物车
        url = config.site.urlRoot + 'cart-info.html';
        $.get(url, function(resp) {
            $('#minicart-total').html(resp.total_quantity + ' 个商品 - ￥' + resp.total_price);
            if (resp.total_quantity > 0) {
                // 处理购物车商品
                $('#minicart-content-table').empty();
                $.each(resp.data, function(i, product) {
                    html = '';
                    html += '<tr>';
                    html += '<td class="text-center">';
                    html += '<a href="">';
                    html += '<img src="'+config.path.thumb+'product/'+product.image_thumb+'" alt="" title="" class="img-thumbnail" style="max-height: 40px;">';
                    html += '</a>';
                    html += '</td>';
                    html += '<td class="text-left">';
                    html += '<a href="">'+product.title+'</a>';
                    html += '<br>';
                    html += 'x ' + product.buy_quantity;
                    html += '</td>';
                    html += '<td class="text-right">';
                    html += '￥' + product.price + '<br>';
                    html += '<a class="remove">移除</a>';
                    html += '</td>';
                    html += '</tr>';
                    $('#minicart-content-table').append(html);
                });
                $('#minicart-total-price').html('￥' + resp.total_price);
            } else {
                $('#minicart-content').html('<li>' +
                    '<p class="text-center empty">您的购物车内没有商品</p>\n' +
                    '</li>');
            }
        }, 'json');
    }

    var cart = {
        add: add,
        minicartRefresh: minicartRefresh
    };

    // 全局化
    window.cart = cart;
}();