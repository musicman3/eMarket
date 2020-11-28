<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<!--Мультиселект-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#multiselect').multiselect({
            //Выбирать группы
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            collapseOptGroupsByDefault: true,
            //Включить живой поиск
            enableFiltering: true,
            //Регистронезависимый живой поиск
            enableCaseInsensitiveFiltering: true,
            //Надписи в живом поиске
            filterPlaceholder: '<?php echo lang('search') ?>',
            //Включить "Выбрать все"
            includeSelectAllOption: true,
            //Надписи "Выбрать все"
            selectAllText: '<?php echo lang('select_all') ?>',
            //"Выбрать все" для раскрытых и не раскрытых стран
            selectAllJustVisible: false,
            //Включить поддержку HTML в названиях
            enableHTML: true,
            //Класс на кнопку
            buttonClass: 'btn btn-primary btn-xs',
            
            //Свой Title на кнопке
            buttonTitle: function () {
                return '<?php echo lang('select_country_and_region') ?>';
            },

            //Надписи на кнопке
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

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
