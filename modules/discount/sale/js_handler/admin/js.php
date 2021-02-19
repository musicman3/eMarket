<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Datepicker" -->
<script src="/ext/moment/moment.min.js"></script>
<?php if (lang('meta-language') != 'en') { ?>
    <script type="text/javascript" src="/ext/moment/locale/<?php echo lang('meta-language') ?>.js"></script>
<?php } ?>
<script src="/ext/pikaday/pikaday.js"></script>
<link rel="stylesheet" type="text/css" href="/ext/pikaday/pikaday.css">
<script type="text/javascript" src="/model/library/js/classes/smartdatepicker.js"></script>

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

            var start = json_data.start[modal_id];
            var end = json_data.end[modal_id];
            new SmartDatepicker(start, end);

            $('#default_module').prop('checked', Number(json_data['default'][modal_id]));
        }

        if (!Number.isInteger(modal_id) && button.data('bs-toggle') === 'modal') {
            $('#edit').val('');
            $('#add').val('ok');
            $(this).find('form').trigger('reset');
            new SmartDatepicker();
        }
    });
</script>

