<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!--Подгружаем bootstrapSwitch -->
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#view_categories_stock').bootstrapSwitch();
</script>

<!--Подгружаем jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>

<?php
// Подгружаем jQuery File Upload
\eMarket\Ajax::fileUpload('', 'categories', $resize_param);
\eMarket\Ajax::fileUploadProduct('', 'products', $resize_param_product);
?>

<!--Подгружаем Категории -->
<?php require_once ('categories.php') ?>

<!--Подгружаем Товары -->
<?php require_once ('products.php') ?>

<!--Подгружаем Атрибуты -->
<?php require_once ('attributes.php') ?>

<!--Подгружаем Summernote -->
<?php require_once ('summernote.php') ?>

<!--Подгружаем Контекстное меню -->
<?php require_once ('context.php') ?>

<!--Подгружаем Действия мышкой -->
<?php require_once ('mouse.php') ?>

<!--Подгружаем Bootstrap Datepicker -->
<?php require_once ('datepicker.php') ?>

<script type="text/javascript">
    function addDataAttributes(group_attributes, attributes, x) {
        $('.product-attribute').prepend(
                '<h4>' + group_attributes['value'] + '</h4><table class="table table-striped product-attribute-table"><tbody id="table_' + x + '"></tbody></table>'
                );

        if (attributes !== undefined && attributes !== null) {
            for (y = 0; y < attributes.length; y++) {
                if (attributes[y][0]['data'] !== undefined && attributes[y][0]['data'] !== null) {
                    $('#table_' + x).prepend(
                            '<tr><td><span class="product-attribute-specification">' + attributes[y][0]['value'] + '</span></td>' +
                            '<td><span class="product-attribute-specification pull-right"><select id="selectattr_' + x + '_' + y + '"></select></span></td></tr>'
                            );
                    
                    $('#selectattr_' + x + '_' + y).empty();
                    attributes[y][0]['data'].reverse();
                    $.each(attributes[y][0]['data'], function (i, p) {
                        $('#selectattr_' + x + '_' + y).append($('<option></option>').val(p).html(p));
                    });
                }
            }
        }

    }
</script>