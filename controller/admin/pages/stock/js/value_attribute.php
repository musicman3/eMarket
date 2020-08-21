<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!--Значения атрибута -->
<script type="text/javascript">

    function addValueAttribute(id, value) {
        $('.values_attribute').prepend(
                '<tr class="value-attributes-class" id="value_attributes_' + id + '">' +
                '<td class="sortyes-value-attributes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-value-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-value-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    function deleteValueAttribute() {
        $('.delete-value-attribute').confirmation({
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
                var group_id = sessionStorage.getItem('group_attribute_id');

                for (x = 0; x < parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1].length; x++) {
                    parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][x]['data'].splice($(this).closest('tr').attr('id').split('_')[2] - 1, 1);
                }
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

                $('.values_attribute').empty();

                for (x = 0; x < parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'].length; x++) {
                    addValueAttribute(x + 1, parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'][x]);
                }
                // Загружаем удаление значения атрибута
                deleteValueAttribute();
            }});
    }


    // Если открыли модал списка значений атрибута
    $(document).on('click', '.values-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[1];
        var group_id = sessionStorage.getItem('group_attribute_id');
        sessionStorage.setItem('value_attribute_action', 'add');
        sessionStorage.setItem('value_attribute_action_id', id);
        sessionStorage.setItem('value_attribute_flag', '1');

        $('#values_attribute').modal('show');
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'))[group_id];
        $('#title_values_attribute').html('Атрибут: ' + parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][0]['value']);

        if ('data' in parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][0] === true) {
            for (x = 0; x < parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'].length; x++) {
                addValueAttribute(x + 1, parse_attributes[sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'][x]);
            }
        }
        // Загружаем удаление значения атрибута
        deleteValueAttribute();
    });

    // Если закрыли модал списка значений атрибута
    $('#values_attribute').on('hidden.bs.modal', function (event) {
        $('.values_attribute').empty();
        sessionStorage.setItem('value_attribute_flag', '0');
    });

    // Если открыли модал добавления значения атрибута
    $(document).on('click', '.add-values-attribute', function () {
        $('#add_values_attribute').modal('show');
        sessionStorage.setItem('value_attribute_action', 'add');
    });

    // Если закрыли модал добавления значения атрибута
    $('#add_values_attribute').on('hidden.bs.modal', function (event) {
        $('.input-add-values-attribute').val('');
        // Загружаем удаление значения атрибута
        deleteValueAttribute();
    });

    // Редактируем значения атрибута
    $(document).on('click', '.edit-value-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[2];
        var group_id = sessionStorage.getItem('group_attribute_id');

        sessionStorage.setItem('value_attribute_action', 'edit');
        sessionStorage.setItem('edit_value_attribute_id', id);

        $('#add_values_attribute').modal('show');

        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'))[group_id][sessionStorage.getItem('value_attribute_action_id') - 1];

        for (x = 0; x < parse_attributes.length; x++) {
            $('input[name="add_values_' + parse_attributes[x]['name'] + '"]').val(parse_attributes[x]['data'][id - 1]);
        }

    });

    // Сохраняем значение атрибута
    $(document).on('click', '#save_add_values_attribute', function () {

        $('#add_values_attribute').modal('hide');

        var value_attributes_bank = $('#add_values_attribute_form').serializeArray();
        var group_id = sessionStorage.getItem('group_attribute_id');
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

        //Если атрибут добавляется
        if (sessionStorage.getItem('value_attribute_action') === 'add') {

            for (x = 0; x < parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1].length; x++) {
                if ('data' in parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][x] !== true) {
                    parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][x]['data'] = [value_attributes_bank[x]['value']];
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                } else {
                    parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][x]['data'].push(value_attributes_bank[x]['value']);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                }
            }

            $('.values_attribute').empty();
            for (x = 0; x < parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'].length; x++) {
                addValueAttribute(x + 1, parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'][x]);
            }
        }

        //Если атрибут редактируется
        if (sessionStorage.getItem('value_attribute_action') === 'edit') {

            for (x = 0; x < parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1].length; x++) {

                parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][x]['data'][sessionStorage.getItem('edit_value_attribute_id') - 1] = value_attributes_bank[x]['value'];
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

            }

            $('.values_attribute').empty();
            for (x = 0; x < parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'].length; x++) {
                addValueAttribute(x + 1, parse_attributes[group_id][sessionStorage.getItem('value_attribute_action_id') - 1][0]['data'][x]);
            }
        }
    });
</script>