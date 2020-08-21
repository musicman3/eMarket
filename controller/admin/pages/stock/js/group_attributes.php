<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!--Атрибуты -->
<script type="text/javascript">

    function addGroupAttribute(id, value) {
        $('.group-attributes').prepend(
                '<tr class="groupattributes" id="groupattributes_' + id + '">' +
                '<td class="sortyes-group sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>' +
                '<td><button type="button" class="values-group-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-group-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-group-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    function deleteGroupAttribute() {
        $('.delete-group-attribute').confirmation({
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
                parse_group_attributes.splice($(this).closest('tr').attr('id').split('_')[1] - 1, 1);
                sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes));

                if ($.parseJSON(sessionStorage.getItem('attributes')) !== undefined) {
                    var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
                    parse_attributes.splice($(this).closest('tr').attr('id').split('_')[1] - 1, 1);
                    sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
                }

                $('.group-attributes').empty();
                for (x = 0; x < parse_group_attributes.length; x++) {
                    var y = x + 1;
                    addGroupAttribute(y, parse_group_attributes[x][0]['value']);
                }
                // Загружаем удаление группы атрибутов
                deleteGroupAttribute();
            }});
    }

    // Если открыли главный модал
    $('#index').on('show.bs.modal', function (event) {

        if (sessionStorage.getItem('group_attributes') !== null) {
            var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));

            for (x = 0; x < parse_group_attributes.length; x++) {
                var y = x + 1;
                addGroupAttribute(y, parse_group_attributes[x][0]['value']);
            }
        } else {
            sessionStorage.setItem('group_attributes', JSON.stringify([]));
        }
        // Загружаем удаление группы атрибутов
        deleteGroupAttribute();
    });

    // Если закрыли главный модал
    $('#index').on('hidden.bs.modal', function (event) {
        $('.group-attributes').empty();
        clearAttributes();
        sessionStorage.removeItem('attributes');
        sessionStorage.removeItem('group_attribute_id');
        sessionStorage.removeItem('group_attributes');
        sessionStorage.removeItem('group_attribute_action');
        sessionStorage.removeItem('edit_group_attribute_id');
    });

    // Если закрыли добавление группы атрибутов
    $('#add_group_attributes').on('hidden.bs.modal', function (event) {
        // Загружаем удаление группы атрибутов
        $('.input-add-group-attributes').val('');
        deleteGroupAttribute();
    });

    // Если открыли модал списка значений группы атрибута
    $(document).on('click', '.values-group-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[1] - 1;
        sessionStorage.setItem('group_attribute_id', id);
        var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));

        $('#attribute').modal('show');
        $('#title_attribute').html('Группа атрибутов: ' + parse_group_attributes[id][0]['value']);

    });

    // Добавляем группу атрибутов
    $(document).on('click', '.add-group-attributes', function () {
        $('#add_group_attributes').modal('show');
        sessionStorage.setItem('group_attribute_action', 'add');
    });

    // Редактируем группу атрибутов
    $(document).on('click', '.edit-group-attribute', function () {
        var group_id = $(this).closest('tr').attr('id').split('_')[1] - 1;
        sessionStorage.setItem('edit_group_attribute_id', group_id);
        sessionStorage.setItem('group_attribute_action', 'edit');

        $('#add_group_attributes').modal('show');

        var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'))[group_id];

        for (x = 0; x < parse_group_attributes.length; x++) {
            $('input[name="' + parse_group_attributes[x]['name'] + '"]').val(parse_group_attributes[x]['value']);
        }

    });

    // Сохраняем значение группы атрибутов
    $(document).on('click', '#save_group_attributes_button', function () {
        $('#add_group_attributes').modal('hide');
        var group_attributes_bank = $('#group_attributes_add_form').serializeArray();
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));

        //Если значение группы атрибутов добавляется
        if (sessionStorage.getItem('group_attribute_action') === 'add') {
            parse_group_attributes.push(group_attributes_bank);
            sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes));

            $('.group-attributes').empty();

            for (x = 0; x < parse_group_attributes.length; x++) {
                var y = x + 1;
                addGroupAttribute(y, parse_group_attributes[x][0]['value']);
            }
        }

        //Если значение группы атрибутов редактируется
        if (sessionStorage.getItem('group_attribute_action') === 'edit') {
            var group_id = sessionStorage.getItem('edit_group_attribute_id');

            parse_group_attributes[group_id] = group_attributes_bank;
            sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes));

            $('.group-attributes').empty();

            for (x = 0; x < parse_group_attributes.length; x++) {
                var y = x + 1;
                addGroupAttribute(y, parse_group_attributes[x][0]['value']);
            }
        }

    });

</script>