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
        tail.select(document.querySelector('#multiselect'), {
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
            placeholder: '<?php echo lang('select_country_and_region') ?>',
            search: '<?php echo lang('search') ?>'
        });
        return select;
    }));
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
