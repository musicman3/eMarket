<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit');
        if (Number.isInteger(modal_id)) {
            var json_data = $('div#ajax_data').data('jsondata');

            $('#zone').val(json_data['zone'][modal_id]);
            $('#minimum_price').val(json_data['price'][modal_id]);
            $('#edit').val(modal_id);
            $('#add').val('');
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            $(this).find('form').trigger('reset');

        }
    });
</script>