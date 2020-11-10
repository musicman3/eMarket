<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

\eMarket\Ajax::сart('');
?>
<script type="text/javascript">
    function pcsProduct(val, id) {
        var a = $('#number_' + id).val();

        if (val === 'minus' && a > 1) {
            $('#number_' + id).val(+a - 1);
        }
        if (val === 'plus') {
            $('#number_' + id).val(+a + 1);
        }
    }
</script>

<!-- Ekko Lightbox" -->
<script type="text/javascript" src="/ext/ekko-lightbox/ekko-lightbox.min.js"></script>
<link href="/ext/ekko-lightbox/ekko-lightbox.css" rel="stylesheet">
<script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>

<script type="text/javascript" src="/model/js/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/js/classes/jsdata/jsdata.js"></script>
<script type="text/javascript">
    new AttributesProcessing();
    // Выводим атрибуты
    $('#selected_attributes').val('<?php echo $products['attributes'] ?>');
    AttributesProcessing.add('catalog', <?php echo json_encode($attributes_data) ?>);
</script>