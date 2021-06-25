<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link href="/ext/tail/tail.select-primary.css" rel="stylesheet" type="text/css">
<script src="/ext/tail/tail.select.min.js" type="text/javascript"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        tail.select(document.querySelector('#permissions'), {
            search: true,
            multiSelectAll: true,
            height: 600,
            width: 450,
            animate: false
        });
    });

    (function (factory) {
        if (typeof (define) === 'function' && define.amd) {
            define(function () {
                return function (select) {
                    factory(select);
                };
            });
        } else {
            if (typeof (window.tail) !== 'undefined' && window.tail.select) {
                factory(window.tail.select);
            }
        }
    }(function (select) {
        select.strings.register('en', {
            all: '<?php echo lang('select_all') ?>',
            none: '<?php echo lang('cancel') ?>',
            actionAll: '<?php echo lang('select_all') ?>',
            empty: '<?php echo lang('no_listing') ?>',
            placeholder: '<?php echo lang('staff_manager_select') ?>',
            search: '<?php echo lang('search') ?>'
        });
        return select;
    }));
</script>
<script type="text/javascript">
    document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit);

        if (Number.isInteger(modal_id)) {
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';

            for (var x = 0; x < json_data.name.length; x++) {
                document.querySelector('#staff_manager_group_' + x).value = json_data.name[x][modal_id];
                document.querySelector('#staff_manager_note_' + x).value = json_data.note[x][modal_id];
            }
            
            var permissions = JSON.parse(json_data.permissions[1]);
            
            for (var y = 0; y < permissions.length; y++) {
                document.querySelector('#hash_' + md5(permissions[y])).setAttribute('selected', true);
            }
            tail.select(document.querySelector('#permissions')).reload();

        } else {
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
            document.querySelectorAll('form').forEach(e => e.reset());
        }
    });
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
