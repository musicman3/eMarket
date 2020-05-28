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
                '<tr id="' + id + '">' +
                '<td>' + value + '</td>' +
                '<td class="al-text-w">' +
                '<div class="b-right"><button class="delete-attribute btn btn-primary btn-xs" title="<?php echo lang('button_delete') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>' +
                '<div class="b-left"><button class="edit-attribute btn btn-primary btn-xs" title="<?php echo lang('button_edit') ?>"><span class="glyphicon glyphicon-edit"> </span></button></div>' +
                '</td>' +
                '</tr>'
                );
    }
    
    // Открываем список значений атирибутов
    $(document).on('click', '.values-attribute', function () {
        //sessionStorage.setItem('attribute_action', 'add');
        $('#add').modal('hide');
        $('#values_attribute').modal('show');
        $('#values_attribute').on('hidden.bs.modal', function (event) {
            $('.attribute').empty();
            $('#add').modal('show');
        });
    });
    
        // Открываем список значений атирибутов
    $(document).on('click', '.add-values-attribute', function () {
        //sessionStorage.setItem('attribute_action', 'add');
        $('#add_values_attribute').modal('show');

    });
</script>