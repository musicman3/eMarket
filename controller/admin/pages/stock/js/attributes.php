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
                '<div class="b-right"><button type="button" class="delete-attribute btn btn-primary btn-xs" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    function clearAttributes() {
        ['attribute_action',
            'attributes',
            'edit_attribute_id',
            'edit_value_attribute_id',
            'value_attribute_action',
            'value_attribute_action_id',
            'value_attribute_flag'
        ].forEach((item) => sessionStorage.removeItem(item));
    }

    // Если открыли главный модал
    $('#index').on('show.bs.modal', function (event) {

        if (sessionStorage.getItem('value_attribute_flag') === null) {
            clearAttributes();
        }

        if (sessionStorage.getItem('attributes') !== null) {
            var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

            for (x = 0; x < parse_attributes.length; x++) {
                var y = x + 1;
                addAttribute(y, parse_attributes[x][0]['value']);
            }
        }

    });

    // Если закрыли главный модал
    $('#index').on('hidden.bs.modal', function (event) {
        $('.attribute').empty();
        if (sessionStorage.getItem('value_attribute_flag') === '0') {
            clearAttributes();
        }
    });

    // Если закрыли модал атрибутов
    $('#attribute').on('hidden.bs.modal', function (event) {
        $('.input-add-attribute').val('');
    });

    // Добавляем атрибут
    $(document).on('click', '.add-attribute', function () {
        sessionStorage.setItem('attribute_action', 'add');
        $('#attribute').modal('show');
    });

    // Редактируем атрибут
    $(document).on('click', '.edit-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[1];

        sessionStorage.setItem('attribute_action', 'edit');
        sessionStorage.setItem('edit_attribute_id', id);

        $('#attribute').modal('show');

        var parse_attributes = [];
        if (sessionStorage.getItem('attributes') !== null) {
            parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'))[id - 1];
        }

        for (x = 0; x < parse_attributes.length; x++) {
            $('input[name="' + parse_attributes[x]['name'] + '"]').val(parse_attributes[x]['value']);
        }

    });

    // Удаляем атрибут
    $(document).on('click', '.delete-attribute', function () {
        $(this).closest('tr').remove();

        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        parse_attributes.splice($(this).closest('tr').attr('id').split('_')[1] - 1, 1);
        sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

        $('.attribute').empty();
        for (x = 0; x < parse_attributes.length; x++) {
            var y = x + 1;
            addAttribute(y, parse_attributes[x][0]['value']);
        }

    });

    // Сохраняем атрибут
    $('#save_attribute_button').click(function () {
        $('#attribute').modal('hide');

        var attributes_bank = $('#attribute_add_form').serializeArray();

        //Если атрибут добавляется
        if (sessionStorage.getItem('attribute_action') === 'add') {

            var parse_attributes = [];

            if (sessionStorage.getItem('attributes') !== null) {
                parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
                parse_attributes.push(attributes_bank);
                sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
            } else {
                sessionStorage.setItem('attributes', JSON.stringify([attributes_bank]));
            }

            var length_attr = parse_attributes.length;

            if (length_attr === 0) {
                length_attr = 1;
            }

            addAttribute(length_attr, attributes_bank[0]['value']);
            sessionStorage.setItem('value_attribute_flag', '0');
        }

        //Если атрибут редактируется
        if (sessionStorage.getItem('attribute_action') === 'edit') {

            var id = sessionStorage.getItem('edit_attribute_id');
            var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));

            parse_attributes[id - 1] = attributes_bank;

            sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));

            $('.attribute').empty();

            for (x = 0; x < parse_attributes.length; x++) {
                var y = x + 1;
                addAttribute(y, parse_attributes[x][0]['value']);
            }
        }

        $('.input-add-attribute').val('');
    });
</script>