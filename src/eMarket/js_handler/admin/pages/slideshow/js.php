<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$resize_max = json_encode(\eMarket\Core\Images::imgResizeMax(\eMarket\Admin\Slideshow::$resize_param));
?>

<!-- Datepicker" -->
<script src="/ext/moment/moment.min.js"></script>
<?php if (lang('meta-language') != 'en') { ?>
    <script type="text/javascript" src="/ext/moment/locale/<?php echo lang('meta-language') ?>.js"></script>
<?php } ?>
<script src="/ext/pikaday/pikaday.js"></script>
<link rel="stylesheet" type="text/css" href="/ext/pikaday/pikaday.css">
<script type="text/javascript" src="/model/library/js/classes/smartdatepicker.js"></script>

<!--File Upload -->
<script type="text/javascript" src="/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/model/library/js/classes/images/fileupload.js"></script>
<script type="text/javascript" src="/js_handler/admin/pages/slideshow/main.js"></script>

<script type="text/javascript">
    new Slideshow();
    var resize_max = <?php echo $resize_max ?>;
    var lang = <?php echo json_encode(lang()) ?>;
    new Fileupload(resize_max, lang);
</script>