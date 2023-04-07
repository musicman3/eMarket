<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- FileUpload -->
<script type="text/javascript" src="/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/model/library/js/classes/images/fileupload.js"></script>
<script type="text/javascript" src="/model/library/js/classes/images/fileupload_product.js"></script>
<!-- Sortable -->
<script type="text/javascript" src="/ext/sortablejs/sortable.min.js"></script>
<!-- Table select -->
<script type="text/javascript" src="/ext/table-select/table-select.js"></script>
<!-- Attributes -->
<script type="text/javascript" src="/model/library/js/classes/attributes/group_attributes.js"></script>
<script type="text/javascript" src="/model/library/js/classes/attributes/attributes.js"></script>
<script type="text/javascript" src="/model/library/js/classes/attributes/values_attribute.js"></script>
<script type="text/javascript" src="/model/library/js/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/library/js/classes/jsdata/jsdata.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="/ext/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<!-- Mouse -->
<script type="text/javascript" src="/model/library/js/classes/mouse/mouse.js"></script>
<!-- Datepicker -->
<script src="/ext/moment/moment.min.js"></script>
<script src="/ext/pikaday/pikaday.js"></script>
<link rel="stylesheet" type="text/css" href="/ext/pikaday/pikaday.css">

<?php if (lang('meta-language') != 'en') { ?>
    <script type="text/javascript" src="/ext/moment/locale/<?php echo lang('meta-language') ?>.js"></script>
<?php } ?>

<script type="text/javascript" src="/js_handler/admin/pages/stock/main.js"></script>

<?php
require_once ('context.php');
