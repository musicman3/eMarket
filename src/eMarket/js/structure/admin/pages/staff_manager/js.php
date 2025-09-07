<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link href="/js/ext/tail/tail.select-primary.css" rel="stylesheet" type="text/css">
<script src="/js/ext/tail/tail.select.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/structure/admin/pages/staff_manager/main.js"></script>
<script type="text/javascript">
    var lang = <?php echo json_encode(lang()) ?>;
    new StaffManager(lang);
</script>
