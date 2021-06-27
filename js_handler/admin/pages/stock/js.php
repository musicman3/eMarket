<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\Files;
use eMarket\Admin\Stock;

$resize_max = json_encode(Files::imgResizeMax(Stock::$resize_param));
$resize_max_prod = json_encode(Files::imgResizeMax(Stock::$resize_param_product));
$lang_js = json_encode([
    'image_resize_error' => lang('image_resize_error'),
    'download_complete' => lang('download_complete')
        ]);

$lang_attributes = json_encode([
    lang('confirm-yes'),
    lang('confirm-no'),
    lang('button_delete'),
    lang('button_edit'),
    lang('#lang_all')[0]
        ]);
?>
<!-- File Upload -->
<script type="text/javascript" src="/ext/lpology/SimpleAjaxUploader.min.js"></script>
<script type="text/javascript" src="/model/library/js/classes/images/fileupload.js"></script>
<script type="text/javascript" src="/model/library/js/classes/images/fileupload_product.js"></script>

<script type="text/javascript">
    var resize_max = JSON.parse('<?php echo $resize_max ?>');
    var resize_max_prod = JSON.parse('<?php echo $resize_max_prod ?>');
    var lang = JSON.parse('<?php echo $lang_js ?>');
    new Fileupload(resize_max, lang);
    new FileuploadProduct(resize_max_prod, lang);
</script>

<script src="/ext/sortablejs/sortable.min.js"></script>
<script src="/ext/table-select/table-select.js"></script>
<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();

    new TableSelect(document.querySelector('#table-id'), {
        selectedClassName: 'table-primary',
        shouldSelectRow(row) {
            return !row.classList.contains('unselectable');
        }
    });

    document.querySelector('#table-id').addEventListener('mousedown', function (event) {
        if (event.ctrlKey) {
            event.preventDefault();
        }
    });
</script>

<?php
require_once ('attributes.php');
require_once ('tinymce.php');
require_once ('context.php');
require_once ('mouse.php');
require_once ('datepicker.php');
