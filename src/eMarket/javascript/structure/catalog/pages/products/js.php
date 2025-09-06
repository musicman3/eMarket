<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Catalog\Products;
?>

<script type="text/javascript" src="/model/library/javascript/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/jsdata/jsdata.js"></script>
<script type="text/javascript" src="/javascript/structure/catalog/pages/products/main.js"></script>
<script type="text/javascript" src="/model/library/javascript/classes/ajax/ajax.js"></script>

<link rel="stylesheet" type="text/css" href="/javascript/ext/baguettebox/baguetteBox.min.css" />
<script type="text/javascript" src="/javascript/ext/baguettebox/baguetteBox.min.js"></script>

<?php if (Products::$products != false) { ?>

    <script type="text/javascript">
        new Ajax();
        document.querySelector('#selected_attributes').value = '<?php echo Products::$products['attributes'] ?>';
        new Products();
        new AttributesProcessing();
        AttributesProcessing.add('catalog', <?php echo json_encode(Products::$attributes_data) ?>, '<?php echo lang('#lang_all')[0] ?>');

        // Litebox
        baguetteBox.run('.gallery');
    </script>

<?php
}