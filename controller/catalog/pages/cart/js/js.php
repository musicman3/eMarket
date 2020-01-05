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
        //Функция получения данных для модулей доставки
        function shippingData() {
            // Устанавливаем методы доставки
            jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                    {shipping_region_json: $(':selected', '#address').data('regions')},
                    AjaxSuccess);
            // Обновление страницы
            function AjaxSuccess(data) {
                var shipping_method = $.parseJSON(data);
                $("#shipping_method").empty();

                if (shipping_method.length < 1) {
                    // Если нет доставки
                    $("#shipping_method").append($('<option value="no"><?php echo lang('cart_shipping_is_not_available') ?></option>'));
                    $('#shipping_method_class').removeClass('has-success');
                    $('#shipping_method_class').addClass('has-error');
                } else {
                    for (x = 0; x < shipping_method.length; x++) {
                        //Если минимальная стоимость заказа ниже указанной
                        if (shipping_method[x]['chanel_total_price'] < shipping_method[x]['chanel_minimum_price']) {
                            $("#shipping_method").append($('<option value="no">' + shipping_method[x]['chanel_name'] + ' <?php echo lang('cart_shipping_is_not_available_and_min_price') ?> ' + shipping_method[x]['chanel_minimum_price_format'] + '</option>'));
                            $('#shipping_method_class').removeClass('has-success');
                            $('#shipping_method_class').addClass('has-error');
                        } else {
                            // Если есть доставка
                            $("#shipping_method").append($('<option value="' + shipping_method[x]['chanel_module'] + '">' + shipping_method[x]['chanel_name'] + '</option>'));
                            $('#shipping_method_class').removeClass('has-error');
                            $('#shipping_method_class').addClass('has-success');
                        }
                    }
                }
            }
        }

        // Получаем данные по доставке
        shippingData();

        // Если выбрали адрес, то перезагружаем методы доставки
        $('#address').change(function (event) {
            // Получаем данные по доставке
            shippingData();
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