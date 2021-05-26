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
    document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit);

        if (Number.isInteger(modal_id)) {
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

            for (var x = 0; x < json_data.name.length; x++) {
                document.querySelector('#name_module_' + x).value = json_data['name'][x][modal_id];
            }

            document.querySelector('#sale_value').value = json_data['value'][modal_id];
            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';

            var start = json_data.start[modal_id];
            var end = json_data.end[modal_id];
            new SmartDatepicker(start, end);

            document.querySelector('#default_module').checked = json_data.default[modal_id];
        } else {
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
            document.querySelectorAll('form').forEach(e => e.reset());
            new SmartDatepicker();
        }
    });
</script>

