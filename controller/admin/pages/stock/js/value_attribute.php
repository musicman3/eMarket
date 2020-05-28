<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!--Значения атрибута -->
<script type="text/javascript">
    // Добавляем атрибут
    $(document).on('click', '.values-attribute', function () {
        //sessionStorage.setItem('attribute_action', 'add');
        $('#add').modal('hide');
        $('#add_values_attribute').modal('show');
        $('#add_values_attribute').on('hidden.bs.modal', function (event) {
            $('.attribute').empty();
            $('#add').modal('show');
        });
    });
</script>