<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Modules
};
?>

<!-- FileUpload -->
<script type="text/javascript" src="/javascript/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/images/fileupload.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/images/fileupload_product.js"></script>
<!-- Sortable -->
<script type="text/javascript" src="/javascript/ext/sortablejs/sortable.min.js"></script>
<!-- Table select -->
<script type="text/javascript" src="/javascript/ext/table-select/table-select.js"></script>
<!-- Attributes -->
<script type="text/javascript" src="/model/library/javascript/classes/attributes/group_attributes.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/attributes/attributes.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/attributes/values_attribute.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/jsdata/jsdata.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="/javascript/ext/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<!-- Mouse -->
<script type="text/javascript" src="/model/library/javascript/classes/mouse/mouse.js"></script>
<!-- Datepicker -->
<script src="/javascript/ext/moment/moment.min.js"></script>
<script src="/javascript/ext/pikaday/pikaday.js"></script>
<link rel="stylesheet" type="text/css" href="/javascript/ext/pikaday/pikaday.css">

<?php if (lang('meta-language') != 'en') { ?>
    <script type="text/javascript" src="/javascript/ext/moment/locale/<?php echo lang('meta-language') ?>.js"></script>
<?php } ?>

<!-- Main Class -->
<script type="text/javascript" src="/javascript/structure/admin/pages/stock/main.js"></script>
<!-- Context Menu -->
<link rel="stylesheet" type="text/css" href="/javascript/ext/ctxmenu/ctxmenu.css" media="screen" />
<script src="/javascript/ext/ctxmenu/ctxmenu.min.js"></script>

<!-- Discount load classes -->
<?php
foreach (Modules::discountRouter('data') as $js_path) {
    echo '<script type="text/javascript" src="/modules/discount/' . $js_path . '/javascript/structure/admin/contextmenu/contextmenu.js"></script>';
}
?>
<!-- Add Discount to context menu (context.js) -->
<script type="text/javascript">
<?php echo Modules::addDiscountsToContextMenu() ?>
</script>

<!-- Init -->
<script type="text/javascript">
    new Stock();
    ctxmenu.attach('#sort-list', []);
</script>