<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default').bootstrapSwitch();
</script>

<!-- Загрузка данных в модальное окно Редактировать -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit') - 1; // Получаем ID из data-edit при клике на кнопку редактирования
        // Получаем массивы данных
        var edit_data = $('div#ajax_data').data('json');
        var countries = $('div#ajax_data').data('countries');

        $("#countries").empty();
        
        if (Number.isInteger(modal_id)) {
            
            $('#default').bootstrapSwitch('destroy', true);

            //Устанавливаем Страну
            for (x = 0; x < countries.length; x++) {
                if (countries[x]['id'] === edit_data[modal_id]['countries_id']) {
                    $("#countries").append($('<option selected value="' + countries[x]['id'] + '">' + countries[x]['name'] + '</option>'));
                } else {
                    $("#countries").append($('<option value="' + countries[x]['id'] + '">' + countries[x]['name'] + '</option>'));
                }
            }
            // Устанавливаем Регион
            jQuery.post(window.location.href,
                    {countries_select: edit_data[modal_id]['countries_id']},
                    AjaxSuccess);
            // Обновление страницы
            function AjaxSuccess(data) {
                var regions = JSON.parse(data);
                $("#regions").empty();

                for (x = 0; x < regions.length; x++) {
                    if (regions[x]['id'] === edit_data[modal_id]['regions_id']) {
                        $("#regions").append($('<option selected value="' + regions[x]['id'] + '">' + regions[x]['name'] + '</option>'));
                    } else {
                        $("#regions").append($('<option value="' + regions[x]['id'] + '">' + regions[x]['name'] + '</option>'));
                    }
                }
            }

            // Если выбрали страну, то загружаем новые регионы
            $('#countries').change(function (event) {
                jQuery.post(window.location.href,
                        {countries_select: $("#countries").val()},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    var regions = JSON.parse(data);
                    $("#regions").empty();

                    for (x = 0; x < regions.length; x++) {
                        if (regions[x]['id'] === edit_data[modal_id]['regions_id']) {
                            $("#regions").append($('<option selected value="' + regions[x]['id'] + '">' + regions[x]['name'] + '</option>'));
                        } else {
                            $("#regions").append($('<option value="' + regions[x]['id'] + '">' + regions[x]['name'] + '</option>'));
                        }
                    }
                }
            });

            //Устанавливаем данные в поля
            $('#city').val(edit_data[modal_id]['city']);
            $('#zip').val(edit_data[modal_id]['zip']);
            $('#address').val(edit_data[modal_id]['address']);
            $('#edit').val(modal_id + 1);
            $('#add').val('');

            // Меняем значение чекбокса
            $('#default').prop('checked', edit_data[modal_id]['default']);
            $('#default').bootstrapSwitch();

        } else {

            // Получаем массивы данных
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');

            //Устанавливаем Страну
            for (x = 0; x < countries.length; x++) {
                $("#countries").append($('<option value="' + countries[x]['id'] + '">' + countries[x]['name'] + '</option>'));
            }

            // Устанавливаем Регион
            jQuery.post(window.location.href,
                    {countries_select: countries[0]['id']},
                    AjaxSuccess);
            // Обновление страницы
            function AjaxSuccess(data) {
                var regions = JSON.parse(data);
                $("#regions").empty();

                for (x = 0; x < regions.length; x++) {
                    $("#regions").append($('<option value="' + regions[x]['id'] + '">' + regions[x]['name'] + '</option>'));
                }
            }
            // Если выбрали страну, то загружаем новые регионы
            $('#countries').change(function (event) {
                jQuery.post(window.location.href,
                        {countries_select: $("#countries").val()},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    var regions = JSON.parse(data);
                    $("#regions").empty();

                    for (x = 0; x < regions.length; x++) {
                        $("#regions").append($('<option value="' + regions[x]['id'] + '">' + regions[x]['name'] + '</option>'));
                    }
                }
            });
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>