<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<!--Мультиселект-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#example-buttonClass-buttonTitle-xss-html-collapseOptGroupsByDefault-buttonText-selectAllText-filterPlaceholder-collapsedClickableOptGroups-enableFiltering-enableCaseInsensitiveFiltering-includeSelectAllOption').multiselect({
            //Выбирать группы
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            collapseOptGroupsByDefault: true,
            //Включить живой поиск
            enableFiltering: true,
            //Регистронезависимый живой поиск
            enableCaseInsensitiveFiltering: true,
            //Надписи в живом поиске
            filterPlaceholder: 'Искать...',
            //Включить "Выбрать все"
            includeSelectAllOption: false,
            //Надписи "Выбрать все"
            selectAllText: 'Выбрать все',
            //Включить поддержку HTML в названиях
            enableHTML: true,
            //Класс на кнопку
            buttonClass: 'btn btn-primary btn-xl',
            
            //Свой Title на кнопке
            buttonTitle: function () {
                return 'Выберите страну и регион';
            },

            //Надписи на кнопке
            buttonText: function (options, select) {
                if (options.length === 0) {
                    return 'Выберите страну и регион';
                } else if (options.length > 0) {
                    return 'Выбрано позиций: ' + options.length + ' шт.';
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




