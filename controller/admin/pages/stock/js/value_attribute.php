<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!--Значения атрибута -->
<script type="text/javascript">

    function addValueAttribute(id, value) {
        $('.values_attribute').append(
                '<tr id="value_attributes_' + id + '">' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button class="delete-value-attribute btn btn-primary btn-xs" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button class="edit-value-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    // Открываем список значений атрибутов
    $(document).on('click', '.values-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[1];
        sessionStorage.setItem('value_attribute_action', 'add');
        sessionStorage.setItem('value_attribute_action_id', id);
        $('#add').modal('hide');

        $('#values_attribute').modal('show');
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        $('#title_values_attribute').html('Атрибут: ' + parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][0]['value']);


        $('#values_attribute').on('hidden.bs.modal', function (event) {
            $('.attribute').empty();
            $('#add').modal('show');
        });
    });

    // Открываем модал значения атрибута
    $(document).on('click', '.add-values-attribute', function () {
        $('#add_values_attribute').modal('show');

    });

    // Сохраняем значение атрибута
    $(document).on('click', '#save_add_values_attribute', function () {

        $('#add_values_attribute').modal('hide');

        var value_attributes_bank = $('#add_values_attribute_form').serializeArray();
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

        //Если атрибут добавляется
        if (sessionStorage.getItem('value_attribute_action') === 'add') {

            for (x = 0; x < parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1].length; x++) {
                if ('data' in parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][x] !== true) {
                    parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][x]['data'] = [value_attributes_bank[x]['value']];
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                } else {
                    parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][x]['data'].push(value_attributes_bank[x]['value']);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                }
            }

            addValueAttribute(sessionStorage.getItem('value_attribute_action_id'), value_attributes_bank[0]['value']);

        }

    });
</script>