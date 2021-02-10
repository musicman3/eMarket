<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Bootstrap Datepicker" -->
<script type="text/javascript" src="/ext/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<link href="/ext/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script type="text/javascript" src="/ext/bootstrap-datepicker/locales/bootstrap-datepicker.<?php echo lang('meta-language') ?>.min.js"></script>
<script type="text/javascript" src="/model/library/js/classes/smartdatepicker.js"></script>

<script type="text/javascript">
    new SmartDatepicker('<?php echo lang('meta-language') ?>');
</script>

<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit');

        if (Number.isInteger(modal_id)) {
            var json_data = $('div#ajax_data').data('jsondata');

            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_module_' + x).val(json_data['name'][x][modal_id]);
            }

            $('#sale_value').val(json_data['value'][modal_id]);
            $('#edit').val(modal_id);
            $('#add').val('');

            var day_start = new Date(json_data['start'][modal_id]);
            $('#start_date').datepicker('setDate', day_start);
            $('#end_date').datepicker('setDate', new Date(json_data['end'][modal_id]));
            if (day_start.setDate(day_start.getDate()) < new Date()) {
                $('#start_date').datepicker('setStartDate', new Date());
                $('#start_date').datepicker('setDate', new Date());
            }

            $('#default_module').prop('checked', Number(json_data['default'][modal_id]));
        }

        if (!Number.isInteger(modal_id) && button.data('bs-toggle') === 'modal') {
            $('#edit').val('');
            $('#add').val('ok');
            $(this).find('form').trigger('reset');
        }
    });
</script>

