<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#shipping_method').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            collapseOptGroupsByDefault: true,
            includeSelectAllOption: true,
            selectAllText: '<?php echo lang('select_all') ?>',
            selectAllJustVisible: false,
            enableHTML: true,
            buttonClass: 'btn btn-primary',

            buttonTitle: function () {
                return '<?php echo lang('modules_payment_cash_admin_shipping_module_select') ?>';
            },

            buttonText: function (options, select) {
                if (options.length === 0) {
                    return '<?php echo lang('modules_payment_cash_admin_shipping_module_select') ?>';
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


