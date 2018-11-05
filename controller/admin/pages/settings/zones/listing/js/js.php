<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<!--Мультиселект-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#example-buttonText-enableCollapsibleOptGroups-collapsedClickableOptGroups-enableFiltering-includeSelectAllOption').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            buttonContainer: '<div id="example-enableCollapsibleOptGroups-collapsed-container" />',
            includeSelectAllOption: true,
            
            //Надписи на кнопке
            buttonText: function (options, select) {
                if (options.length === 0) {
                    return 'Выберите страну и регион ...';
                } else if (options.length > 0) {
                    return 'Выбрано позиций: '+options.length+' шт.';
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
        $('#example-enableCollapsibleOptGroups-collapsed-container .caret-container').click();
    });
</script>




