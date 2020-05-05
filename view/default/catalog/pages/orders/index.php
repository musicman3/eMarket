<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>

<!-- Модальное окно "Добавить" -->
<?php require_once('modal/add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<!-- Модальное окно "Редактировать" -->
<?php require_once('modal/edit.php') ?>
<!-- КОНЕЦ Модальное окно "Редактировать" -->

<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1><?php echo lang('orders_book') ?></h1>

<div id="ajax_data" class='hidden'
     data-json='<?php echo $address_data_json ?>'
     data-countries='<?php echo $countries_data_json ?>'
     ></div>

<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th><?php echo lang('№ заказа') ?></th>
            <th class="al-text"><?php echo lang('Итого') ?></th>
            <th class="al-text"><?php echo lang('Дата заказа') ?></th>
            <th class="al-text"><?php echo lang('Статус') ?></th>
            <th class="al-text-w"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($orders_data != FALSE) {
            $x = 1;
            foreach ($orders_data as $val) {
                ?>
                <tr>
                    <td><?php echo $val['id'] ?></td>
                    <td class="al-text"><?php echo json_decode($val['order_total'], 1)['customer']['total_with_shipping_format'] ?></td>
                    <td class="al-text"><?php echo $val['date_purchased'] ?></td>
                    <td class="al-text"><?php echo json_decode($val['orders_status_history'], 1)[0]['customer']['status'] ?></td>

                    <td class="al-text-w">
                        <!--Вызов модального окна для редактирования-->
                        <div class="b-right">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit" data-edit="<?php echo $x ?>"><span class="glyphicon glyphicon-edit"></span></button>
                        </div>
                    </td>
                </tr>
                <?php
                $x++;
            }
        }
        ?>

    </tbody>
</table>
