<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

\eMarket\Ajax::сart('');
?>

<!-- Загрузка данных в модальное окно Корзина -->

<script type = "text/javascript">
    $('#cart').on('show.bs.modal', function (event) {
        //Функция замены класса
        function replaceClass(nameClass, reverse = true) {
            if (reverse === true) {
                $(nameClass).removeClass('has-error');
                $(nameClass).addClass('has-success');
            } else {
                $(nameClass).removeClass('has-success');
                $(nameClass).addClass('has-error');
        }
        }

        // Устанавливаем методы доставки
        jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                {shipping_region_json: $(':selected', '#address').data('regions')},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            var shipping_method = $.parseJSON(data);
            $("#shipping_method").empty();

            if (shipping_method.length < 1) {
                $("#shipping_method").append($('<option value="no"><?php echo lang('cart_shipping_is_not_available') ?></option>'));
                replaceClass('#shipping_method_class', false);
            } else {
                for (x = 0; x < shipping_method.length; x++) {
                    $("#shipping_method").append($('<option value="' + shipping_method[x]['chanel_module'] + '">' + shipping_method[x]['chanel_name'] + '</option>'));
                    replaceClass('#shipping_method_class', true);
                }
            }
        }
        // Если выбрали адрес, то загружаем методы доставки
        $('#address').change(function (event) {
            jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                    {shipping_region_json: $(':selected', this).data('regions')},
                    AjaxSuccess);
            // Обновление страницы
            function AjaxSuccess(data) {
                var shipping_method = $.parseJSON(data);
                $("#shipping_method").empty();

                if (shipping_method.length < 1) {
                    $("#shipping_method").append($('<option value="no"><?php echo lang('cart_shipping_is_not_available') ?></option>'));
                    replaceClass('#shipping_method_class', false);
                } else {
                    for (x = 0; x < shipping_method.length; x++) {
                        $("#shipping_method").append($('<option value="' + shipping_method[x]['chanel_module'] + '">' + shipping_method[x]['chanel_name'] + '</option>'));
                        replaceClass('#shipping_method_class', true);
                    }
                }
            }
        });
    });
</script>

<script type="text/javascript">
    function pcsProduct(val, id) {
        var a = $('#number_' + id).val();

        if (val === 'minus' && a > 1) {
            $('#number_' + id).val(+a - 1);
        }
        if (val === 'plus') {
            $('#number_' + id).val(+a + 1);
        }
    }
</script>