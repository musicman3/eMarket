<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Модальное окно "Добавить категорию" -->
<script type="text/javascript">
    function callAdd() {
        var msg = $('#form_add').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=stock',
            data: msg,
            beforeSend: function (data) {
                $('#add').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('?route=stock',
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'update_ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<!-- Модальное окно "Редактировать категорию" -->
<script type="text/javascript">
    function callEdit() {
        var msg = $('#form_edit').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=stock',
            data: msg,
            beforeSend: function (data) {
                $('#edit').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('?route=stock',
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                $('#fileupload-edit').fileupload('destroy');
                $('#fileupload-add').fileupload('destroy');
                $('#fileupload-edit-product').fileupload('destroy');
                $('#fileupload-add-product').fileupload('destroy');
                $('#ajax').html(data);
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<!-- Модальное окно "Добавить товар" -->
<script type="text/javascript">
    function callAddProduct() {
        var msg = $('#form_add_product').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=stock',
            data: msg,
            beforeSend: function (data) {
                $('#add_product').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('?route=stock',
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'update_ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<!-- Модальное окно "Редактировать товар" -->
<script type="text/javascript">
    function callEditProduct() {
        var msg = $('#form_edit_product').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=stock',
            data: msg,
            beforeSend: function (data) {
                $('#edit_product').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('?route=stock',
                {parent_down: <?php echo $parent_id ?>,
                    modify: 'update_ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
            }, 100);
            $("#sort-list").sortable();
        }
    }
</script>

<!--Подгружаем jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
<?php
// Подгружаем jQuery File Upload
\eMarket\Ajax::fileUpload('?route=stock', 'categories', $resize_param);
\eMarket\Ajax::fileUploadProduct('?route=stock', 'products', $resize_param_product);
?>

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