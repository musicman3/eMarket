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
    $('#default_edit').bootstrapSwitch();
</script>

<script type = "text/javascript">
    $('#countries').change(function (event) {
        jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                {countries_select: $("#countries").val()},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            var result = $.parseJSON(data);
            $("#regions").empty();

            for (x = 0; x < result.length; x++) {
                $("#regions").append($('<option value="' + result[x]['id'] + '">' + result[x]['name'] + '</option>'));
            }

        }
    });
</script>


<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#edit').on('show.bs.modal', function (event) {
        $('#default_edit').bootstrapSwitch('destroy', true);
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit') - 1; // Получаем ID из data-edit при клике на кнопку редактирования

        // Получаем массивы данных
        var edit_data = $('div#ajax_data').data('json');
        var countries = $('div#ajax_data').data('countries');
        
        $("#countries_edit").empty();
        
        //Устанавливаем Страну
        for (x = 0; x < countries.length; x++) {
            if (countries[x]['id'] === edit_data[modal_id]['countries_id']) {
                $("#countries_edit").append($('<option selected value="' + countries[x]['id'] + '">' + countries[x]['name'] + '</option>'));
            } else {
                $("#countries_edit").append($('<option value="' + countries[x]['id'] + '">' + countries[x]['name'] + '</option>'));
            }
        }
        // Устанавливаем Регион
        jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                {countries_select: edit_data[modal_id]['countries_id']},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            var result = $.parseJSON(data);
            $("#regions_edit").empty();

            for (x = 0; x < result.length; x++) {
                $("#regions_edit").append($('<option value="' + result[x]['id'] + '">' + result[x]['name'] + '</option>'));
            }
        }
        // Выбираем регион при переключении страны
        $('#countries_edit').change(function (event) {
            jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                    {countries_select: $("#countries_edit").val()},
                    AjaxSuccess);
            // Обновление страницы
            function AjaxSuccess(data) {
                var result = $.parseJSON(data);
                $("#regions_edit").empty();

                for (x = 0; x < result.length; x++) {
                    $("#regions_edit").append($('<option value="' + result[x]['id'] + '">' + result[x]['name'] + '</option>'));
                }

            }
        });

        $('#city_edit').val(edit_data[modal_id]['city']);
        $('#zip_edit').val(edit_data[modal_id]['zip']);
        $('#address_edit').val(edit_data[modal_id]['address']);
        $('#js_edit').val(modal_id);

        // Меняем значение чекбокса
        $('#default_edit').prop('checked', edit_data[modal_id]['default']);
        $('#default_edit').bootstrapSwitch();
    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>