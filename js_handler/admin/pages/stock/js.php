<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\Files;
use eMarket\Admin\Stock;

$resize_max = json_encode(Files::imgResizeMax(Stock::$resize_param));
$resize_max_prod = json_encode(Files::imgResizeMax(Stock::$resize_param_product));
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

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript" src="/js_handler/admin/pages/stock/main.js"></script>

<script type="text/javascript">
    var resize_max = <?php echo $resize_max ?>;
    var resize_max_prod = <?php echo $resize_max_prod ?>;
    var lang = <?php echo json_encode(lang()) ?>;

    new Stock(resize_max, lang, resize_max_prod);
</script>

<?php
require_once ('context.php');
