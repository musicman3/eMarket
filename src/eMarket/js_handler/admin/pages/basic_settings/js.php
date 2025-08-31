<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<script type="text/javascript" src="/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/js_handler/admin/pages/basic_settings/main.js"></script>
<?php if (Valid::$demo_mode == FALSE) { ?>
    <script type="text/javascript" src="/model/library/js/classes/update/update.js"></script>
<?php } ?>
<script type="text/javascript">
    new BasicSettings();
<?php if (Valid::$demo_mode == FALSE) { ?>
        new Update();
<?php } ?>
</script>