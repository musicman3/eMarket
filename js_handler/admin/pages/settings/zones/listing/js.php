<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#multiselect').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            collapseOptGroupsByDefault: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: '<?php echo lang('search') ?>',
            includeSelectAllOption: true,
            selectAllText: '<?php echo lang('select_all') ?>',
            selectAllJustVisible: false,
            enableHTML: true,
            buttonClass: 'btn btn-primary btn-sm',

            buttonTitle: function () {
                return '<?php echo lang('select_country_and_region') ?>';
            },

            buttonText: function (options, select) {
                if (options.length === 0) {
                    return '<?php echo lang('select_country_and_region') ?>';
                } else if (options.length > 0) {
                    return '<?php echo lang('positions_selected') ?>: ' + options.length + ' <?php echo lang('pcs') ?>';
                } else {
                    var labels = [];
                    options.each(function () {
                        if ($(this).attr('label') !== undefined) {
                            labels.push($(this).attr('label'));
                        } else {
                            labels.push($(this).html());
                        }
                    });
                    return labels.join(', ') + '';
                }
            }

        });
    });
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
