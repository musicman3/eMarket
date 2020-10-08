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

<!-- Модальное окно "Редактировать" -->
<?php require_once('modal/index.php') ?>
<!-- КОНЕЦ Модальное окно "Редактировать" -->

<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1><?php echo lang('orders_book') ?></h1>

<div id="ajax_data" class='hidden'
     data-orders='<?php echo $orders_edit ?>'
     ></div>

<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="4">
                <?php if ($lines == TRUE) { ?>
                    <div class="page"><?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo $count_lines; ?> )</div>
                    <?php
                } else {
                    ?>
                    <div><?php echo lang('no_listing') ?></div>
                <?php } ?>
            </th>

            <th>

                <?php if ($count_lines > $lines_on_page) { ?>
                    <form>
                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                        <input hidden name="start" value="<?php echo $start ?>">
                        <input hidden name="finish" value="<?php echo $finish ?>">
                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                    </form>

                    <form>
                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                        <input hidden name="backstart" value="<?php echo $start ?>">
                        <input hidden name="backfinish" value="<?php echo $finish ?>">
                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>

                    </form>
                <?php } ?>

            </th>
        </tr>
        <tr>
            <th><?php echo lang('orders_number') ?></th>
            <th class="al-text"><?php echo lang('orders_total') ?></th>
            <th class="al-text"><?php echo lang('orders_date_added') ?></th>
            <th class="al-text"><?php echo lang('orders_status') ?></th>
            <th class="al-text-w"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($lines != FALSE) {
            for ($start; $start < $finish; $start++) {
                ?>
                <tr>
                    <td><?php echo $lines[$start]['id'] ?></td>
                    <td class="al-text"><?php echo json_decode($lines[$start]['order_total'], 1)['customer']['total_with_shipping_format'] ?></td>
                    <td class="al-text"><?php echo $lines[$start]['date_purchased'] ?></td>
                    <td class="al-text"><?php echo json_decode($lines[$start]['orders_status_history'], 1)[0]['customer']['status'] ?></td>

                    <td class="al-text-w">
                        <!--Вызов модального окна для редактирования-->
                        <div class="b-right">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#index" data-edit="<?php echo $lines[$start]['id'] ?>"><span class="glyphicon glyphicon-edit"></span></button>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }
        ?>

    </tbody>
</table>
