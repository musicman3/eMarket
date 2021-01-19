<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Catalog\Products;
?>

<!-- Ekko Lightbox" -->
<script type="text/javascript" src="/ext/ekko-lightbox/ekko-lightbox.min.js"></script>
<link href="/ext/ekko-lightbox/ekko-lightbox.min.css" rel="stylesheet">
<script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>

<script type="text/javascript" src="/model/js/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/js/classes/jsdata/jsdata.js"></script>
<script type="text/javascript" src="/model/js/classes/products/products.js"></script>
<script type="text/javascript">
    $('#selected_attributes').val('<?php echo Products::$products['attributes'] ?>');
    new Products();
    new AttributesProcessing();
    AttributesProcessing.add('catalog', <?php echo json_encode(Products::$attributes_data) ?>, '<?php echo lang('#lang_all')[0] ?>');
</script>