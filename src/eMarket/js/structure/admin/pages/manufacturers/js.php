<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$resize_max = json_encode(\eMarket\Core\Images::imgResizeMax(eMarket\Admin\Manufacturers::$resize_param));
?>
<script type="text/javascript" src="/js/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/js/library/classes/images/fileupload.js"></script>
<script type="text/javascript" src="/js/structure/admin/pages/manufacturers/main.js"></script>

<script type="text/javascript">
    var resize_max = <?php echo $resize_max ?>;
    var lang = <?php echo json_encode(lang()) ?>;
    new Fileupload(resize_max, lang);
    new Manufacturers();
</script>
