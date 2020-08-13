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
                '<tr id="groupattributes_' + id + '">' +
                '<td class="sortleft"><button type="button" class="values-group-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button></td>' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button type="button" class="delete-group-attribute btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button type="button" class="edit-group-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }

    // Если открыли главный модал
    $('#index').on('show.bs.modal', function (event) {

        if (sessionStorage.getItem('value_attribute_flag') === null) {
            clearAttributes();
        }

        if (sessionStorage.getItem('attributes') !== null && sessionStorage.getItem('group_attributes') !== null) {
            var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));

            for (x = 0; x < parse_group_attributes.length; x++) {
                var y = x + 1;
                addGroupAttribute(y, parse_group_attributes[x][0]['value']);
            }
        } else {
            sessionStorage.setItem('attributes', JSON.stringify([]));
        }
    });

    // Если закрыли главный модал
    $('#index').on('hidden.bs.modal', function (event) {
        $('.group-attributes').empty();
        if (sessionStorage.getItem('value_attribute_flag') === '0') {
            clearAttributes();
            sessionStorage.removeItem('attributes');
            sessionStorage.removeItem('group_attribute_id');
        }
    });

    // Если открыли модал списка значений группы атрибута
    $(document).on('click', '.values-group-attribute', function () {
        var id = $(this).closest('tr').attr('id').split('_')[1] - 1;
        sessionStorage.setItem('group_attribute_id', id);

        $('#attribute').modal('show');
        //var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        $('#title_attribute').html('Группа атрибутов: ' + id);

    });

    // Добавляем группу атрибутов
    $(document).on('click', '.add-group-attributes', function () {
        $('#add_group_attributes').modal('show');
    });

    // Сохраняем значение группы атрибутов
    $(document).on('click', '#save_group_attributes_button', function () {
        $('#add_group_attributes').modal('hide');
        var parse_attributes = $.parseJSON(sessionStorage.getItem('attributes'));
        var parse_group_attributes = $.parseJSON(sessionStorage.getItem('group_attributes'));
        var group_attributes_bank = $('#group_attributes_add_form').serializeArray();

        parse_attributes.push([]);
        parse_group_attributes.push(group_attributes_bank);
        sessionStorage.setItem('attributes', JSON.stringify(parse_attributes));
        sessionStorage.setItem('group_attributes', JSON.stringify(parse_group_attributes));

        $('.group-attributes').empty();

        for (x = 0; x < parse_attributes.length; x++) {
            var y = x + 1;
            addGroupAttribute(y, parse_group_attributes[x][0]['value']);
        }


    });

</script>