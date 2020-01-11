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
                    $('#shipping_price').html('<?php echo lang('cart_shipping_price') ?> <b><?php echo \eMarket\Products::productPrice(0, 1) ?></b>');
                    $('#total_price_modal').html('<h5><?php echo lang('cart_total_to_pay') ?> <?php echo \eMarket\Products::productPrice(\eMarket\Ecb::totalPriceCartWithSale(), 1) ?></h5>');
                } else {
                    for (var shipping_val of shipping_method) {
                        //Если минимальная стоимость заказа ниже указанной
                        if (shipping_val['chanel_total_price'] < shipping_val['chanel_minimum_price']) {
                            $("#shipping_method").append($('<option value="no">' + shipping_val['chanel_name'] + '<?php echo lang('cart_shipping_is_not_available_and_min_price') ?> ' + shipping_val['chanel_minimum_price_format'] + '</option>'));
                            $('#shipping_method_class').removeClass('has-success');
                            $('#shipping_method_class').addClass('has-error');
                            $('#shipping_price').html('<?php echo lang('cart_shipping_price') ?> <b>' + shipping_val['chanel_shipping_price_format'] + '</b>');
                            $('#total_price_modal').html('<h5><?php echo lang('cart_total_to_pay') ?> ' + shipping_val['chanel_total_price_with_shipping_format'] + '</h5>');
                        } else {
                            // Если есть доставка
                            $("#shipping_method").append($('<option value="' + shipping_val['chanel_module_name'] + '" data-shipping="' + shipping_val['chanel_id'] + '">' + shipping_val['chanel_name'] + '</option>'));
                            $('#shipping_method_class').removeClass('has-error');
                            $('#shipping_method_class').addClass('has-success');
                            $('#shipping_price').html('<?php echo lang('cart_shipping_price') ?> <b>' + shipping_val['chanel_shipping_price_format'] + '</b>');
                            $('#total_price_modal').html('<h5><?php echo lang('cart_total_to_pay') ?> ' + shipping_val['chanel_total_price_with_shipping_format'] + '</h5>');
                        }
                    }
                }
                // Делаем не активной кнопку завершения заказа, если селекты не валидны
                if ($("#address_class").attr("class") !== 'input-group has-success' || $("#shipping_method_class").attr("class") !== 'input-group has-success' || $("#payment_method_class").attr("class") !== 'input-group has-success') {
                    $("#complete").attr("disabled", "disabled");
                } else {
                    $("#complete").removeAttr("disabled");
                }
            }
        }

        //Функция получения данных для модулей оплаты
        function paymentData() {
            // Устанавливаем методы доставки
            jQuery.post('<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>',
                    {payment_shipping_json: $(':selected', '#shipping_method').val()},
                    AjaxSuccess);
            // Обновление страницы
            function AjaxSuccess(data) {
                var payment_method = $.parseJSON(data);
                $("#payment_method").empty();

                if (payment_method.length < 1) {
                    // Если нет оплаты
                    $("#payment_method").append($('<option value="no"><?php echo lang('cart_payment_is_not_available') ?></option>'));
                    $('#payment_method_class').removeClass('has-success');
                    $('#payment_method_class').addClass('has-error');
                } else {
                    for (var payment_val of payment_method) {
                        // Если есть оплата
                        $("#payment_method").append($('<option value="' + payment_val['chanel_module_name'] + '">' + payment_val['chanel_name'] + '</option>'));
                        $('#payment_method_class').removeClass('has-error');
                        $('#payment_method_class').addClass('has-success');

                    }
                }
                // Делаем не активной кнопку завершения заказа, если селекты не валидны
                if ($("#address_class").attr("class") !== 'input-group has-success' || $("#shipping_method_class").attr("class") !== 'input-group has-success' || $("#payment_method_class").attr("class") !== 'input-group has-success') {
                    $("#complete").attr("disabled", "disabled");
                } else {
                    $("#complete").removeAttr("disabled");
                }
            }
        }

        // Получаем данные
        shippingData();
        setTimeout(function () {
            paymentData();
        }, 100);


        // Если выбрали адрес, то перезагружаем методы доставки
        $('#address').change(function (event) {
            // Получаем данные по доставке
            shippingData();
        });
        // Если выбрали доставку, то перезагружаем методы оплаты
        $('#shipping_method').change(function (event) {
            // Получаем данные по доставке
            paymentData();
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