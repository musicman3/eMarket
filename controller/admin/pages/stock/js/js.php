<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$resize_max = json_encode(\eMarket\Files::imgResizeMax($resize_param));
$lang_js = json_encode([
    'image_resize_error' => lang('image_resize_error'),
    'download_complete' => lang('download_complete')
        ]);
?>
<!--Подгружаем jQuery File Upload -->
<script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/model/js/classes/images/fileupload.js"></script>

<!--Подгружаем bootstrapSwitch -->
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#view_categories_stock').bootstrapSwitch();
    
    var resize_max = $.parseJSON('<?php echo $resize_max ?>');
    var lang = $.parseJSON('<?php echo $lang_js ?>');
    new Fileupload(resize_max, lang);
</script>

<?php
// Подгружаем jQuery File Upload
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