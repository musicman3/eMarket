<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use R2D2\R2\Valid;
?>
<script type="text/javascript" src="/js/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/js/structure/admin/pages/basic_settings/main.js"></script>
<?php if (Valid::$demo_mode == FALSE) { ?>
    <script type="text/javascript" src="/js/structure/admin/pages/basic_settings/update.js"></script>
<?php } ?>
<script type="text/javascript">
<?php if (Valid::$demo_mode == FALSE) { ?>
        new Update();
        new BasicSettings();
<?php } ?>
</script>
