/*
 * Products list script
 */

import './styles/products_list.scss';

$(document).ready(function() {
    $('.product-item__delete-button').click(function () {
        const id = $(this).closest('.product-item').data('id');
        $.ajax({
            url: '/user/product/delete',
            method: 'GET',
            data: {id: id},
            success: function(data) {
                if (data.reloadPage) {
                    location.reload();
                }
            }
        });
    });
});