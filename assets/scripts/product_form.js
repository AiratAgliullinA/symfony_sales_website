/*
 * Product form script
 */

$(document).ready(function() {
    $('.product-form__uploaded-image .remove').click(function () {
        const productForm = $(this).closest('.product-form');
        productForm.find('.product-form__uploaded-image').hide(500);
        productForm.find('.product-form__upload-image').show(500);
        $('#product_form_isRemoveImage').val(true);
    });
});