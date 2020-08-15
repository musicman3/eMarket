<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!--Атрибуты -->
<script type="text/javascript">

    function addAttribute(id, value) {
        $('.attribute').prepend(
                '<tr id="attributes_' + id + '">' +
                '<td class="sortleft"><button type="button" class="values-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    function clearAttributes() {
        ['attribute_action',
            'edit_attribute_id',
            'edit_value_attribute_id',
            'value_attribute_action',
            'value_attribute_action_id',
            'value_attribute_flag'
        ].forEach((item) => sessionStorage.removeItem(item));
    }

    function deleteAttribute() {
        $('.delete-attribute').confirmation({
            onConfirm: function (event) {
                $(this).closest('tr').remove();

                var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
                var group_id = sessionStorage.getItem('group_attribute_id');

                parse_attributes[group_id].splice($(this).closest('tr').attr('id').split('_')[1] - 1, 1);

                if (parse_attributes[group_id].length === 0) {
                    parse_attributes = [];
                }
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

                $('.attribute').empty();
                for (x = 0; x < parse_attributes[group_id].length; x++) {
                    var y = x + 1;
                    addAttribute(y, parse_attributes[group_id][x][0]['value']);
                }
                // Загружаем удаление атрибута
                deleteAttribute();
            }});
    }

    // Если открыли модал списка в группе атрибутов
    $('#attribute').on('show.bs.modal', function (event) {

        if (sessionStorage.getItem('value_attribute_flag') === null) {
            clearAttributes();
        }
        var group_id = sessionStorage.getItem('group_attribute_id');

        if (sessionStorage.getItem('attributes') !== null) {
            var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

            if (parse_attributes[group_id] !== undefined) {
                for (x = 0; x < parse_attributes[group_id].length; x++) {
                    var y = x + 1;
                    addAttribute(y, parse_attributes[group_id][x][0]['value']);
                }
            }
        }
        // Загружаем удаление атрибута
        deleteAttribute();

    });

    // Если закрыли модал списка в группе атрибутов
    $('#attribute').on('hidden.bs.modal', function (event) {
        $('.attribute').empty();
        if (sessionStorage.getItem('value_attribute_flag') === '0') {
            clearAttributes();
        }
    });

    // Если закрыли модал значения атрибута
    $('#add_attribute').on('hidden.bs.modal', function (event) {
        $('.input-add-attribute').val('');
        // Загружаем удаление атрибута
        deleteAttribute();
    });

    // Добавляем атрибут
    $(document).on('click', '.add-attribute', function () {
        sessionStorage.setItem('attribute_action', 'add');
        $('#add_attribute').modal('show');
    });

    // Редактируем атрибут
    $(document).on('click', '.edit-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[1];
        var group_id = sessionStorage.getItem('group_attribute_id');

        sessionStorage.setItem('attribute_action', 'edit');
        sessionStorage.setItem('edit_attribute_id', id);

        $('#add_attribute').modal('show');

        var parse_attributes = [];
        if (sessionStorage.getItem('attributes') !== null) {
            parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'))[group_id][id - 1];
        }

        for (x = 0; x < parse_attributes.length; x++) {
            $('input[name="' + parse_attributes[x]['name'] + '"]').val(parse_attributes[x]['value']);
        }

    });

    // Сохраняем атрибут
    $('#save_attribute_button').click(function () {
        $('#add_attribute').modal('hide');

        var attributes_bank = $('#attribute_add_form').serializeArray();
        var group_id = sessionStorage.getItem('group_attribute_id');
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

        //Если атрибут добавляется
        if (sessionStorage.getItem('attribute_action') === 'add') {
            if (parse_attributes === null || parse_attributes.length === 0) {
                parse_attributes = [];
            }
            if (parse_attributes[group_id] === undefined) {
                parse_attributes[group_id] = [];
            }

            parse_attributes[group_id].push(attributes_bank);
            sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

            $('.attribute').empty();

            for (x = 0; x < parse_attributes[group_id].length; x++) {
                var y = x + 1;
                addAttribute(y, parse_attributes[group_id][x][0]['value']);
            }
            sessionStorage.setItem('value_attribute_flag', '0');
        }

        //Если атрибут редактируется
        if (sessionStorage.getItem('attribute_action') === 'edit') {

            var id = sessionStorage.getItem('edit_attribute_id');

            for (x = 0; x < attributes_bank.length; x++) {
                for (y = 0; y < parse_attributes[group_id][id - 1].length; y++) {
                    if (parse_attributes[group_id][id - 1][x]['name'] === attributes_bank[y]['name']) {
                        parse_attributes[group_id][id - 1][x]['value'] = attributes_bank[y]['value'];
                    }
                }
            }

            sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

            $('.attribute').empty();

            for (x = 0; x < parse_attributes[group_id].length; x++) {
                var y = x + 1;
                addAttribute(y, parse_attributes[group_id][x][0]['value']);
            }
        }

        $('.input-add-attribute').val('');
    });
</script>