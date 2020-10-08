<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Вставляем модальное окно "Категория" -->
<?php require_once('modal/index.php') ?>

<!-- Вставляем модальное окно "Товар" -->
<?php require_once('modal/index_product.php') ?>

<!-- Модальное окно "Подтверждение" -->
<?php require_once('modal/confirm.php') ?>
<!-- КОНЕЦ Модальное окно "Подтверждение" -->

<!-- Модальное окно "Атрибуты" -->
<?php require_once('modal/attribute.php') ?>
<!-- КОНЕЦ Модальное окно "Атрибуты" -->

<!-- Модальное окно "Добавить Группу атрибутов" -->
<?php require_once('modal/add_group_attributes.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить Группу атрибутов" -->

<!-- Модальное окно "Добавить Атрибут" -->
<?php require_once('modal/add_attribute.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить Атрибут" -->

<!-- Модальное окно "Добавить имя атрибута" -->
<?php require_once('modal/values_attribute.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить имя атрибута" -->

<!-- Модальное окно "Добавить значения атрибута" -->
<?php require_once('modal/add_values_attribute.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить значения атрибута" -->

<div id="ajax">

    <div class="container-fluid">
        <div class="panel panel-default">

            <div class="panel-heading">

                <!--Выводим уведомление об успешном действии-->
                <?php \eMarket\Messages::alert(); ?>

                <h3 class="panel-title">
                    <div class="pull-left"><?php echo \eMarket\Set::titlePageGenerator() ?></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <?php if ($lines_cat == TRUE OR $lines_prod == TRUE) { ?>
                <div class="panel-body">
                    <!--Скрытый div для передачи данных-->
                    <div id="ajax_data" class='hidden'
                         data-name='<?php echo $name ?>'
                         data-logo='<?php echo $logo ?>'
                         data-general='<?php echo $logo_general ?>'
                         data-attributes='<?php echo $attributes ?>'
                         data-logoproduct='<?php echo $logo_product ?>'
                         data-generalproduct='<?php echo $logo_general_product ?>'
                         data-nameproduct='<?php echo $name_product ?>'
                         data-descriptionproduct='<?php echo $description_product ?>'
                         data-keywordproduct='<?php echo $keyword_product ?>'
                         data-tagsproduct='<?php echo $tags_product ?>'
                         data-priceproduct='<?php echo $price_product ?>'
                         data-currencyproduct='<?php echo $currency_product ?>'
                         data-quantityproduct='<?php echo $quantity_product ?>'
                         data-unitsproduct='<?php echo $units_product ?>'
                         data-modelproduct='<?php echo $model_product ?>'
                         data-manufacturersproduct='<?php echo $manufacturers_product ?>'
                         data-dateavailableproduct='<?php echo $date_available_product ?>'
                         data-taxproduct='<?php echo $tax_product ?>'
                         data-vendorcodevalueproduct='<?php echo $vendor_code_value_product ?>'
                         data-vendorcodeproduct='<?php echo $vendor_code_product ?>'
                         data-weightvalueproduct='<?php echo $weight_value_product ?>'
                         data-weightproduct='<?php echo $weight_product ?>'
                         data-minquantityproduct='<?php echo $min_quantity_product ?>'
                         data-dimensionproduct='<?php echo $dimension_product ?>'
                         data-lengthproduct='<?php echo $length_product ?>'
                         data-widthproduct='<?php echo $width_product ?>'
                         data-heightproduct='<?php echo $height_product ?>'
                         data-attributesselected='<?php echo $attributes_product ?>'
                         data-attributesdata='<?php echo $attributes_data ?>'
                         ></div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    <?php
                                    // Счетчик в навигации
                                    if ($finish == $count_lines_merge && ($finish - $start) <= $lines_on_page OR $finish == $lines_on_page) {
                                        $finish_out = $finish;
                                    } else {
                                        $finish_out = $finish - 1;
                                    }
                                    ?>

                                    <div class="page"><?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish_out ?> ( <?php echo lang('of') ?> <?php echo $count_lines_merge; ?> )</div>

                                    <!-- Переключаем страницу "ВПЕРЕД" -->
                                    <?php if ($count_lines_merge > $lines_on_page) { ?>
                                        <form>
                                            <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                            <input hidden name="start" value="<?php echo $start ?>">
                                            <input hidden name="finish" value="<?php echo $finish ?>">
                                            <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                            <div class="b-right"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                        </form>

                                        <!-- Переключаем страницу "НАЗАД" -->
                                        <form>
                                            <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                            <input hidden name="backstart" value="<?php echo $start ?>">
                                            <input hidden name="backfinish" value="<?php echo $finish ?>">
                                            <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                            <div class="b-left"><button type="submit" class="btn btn-primary btn-xs"  action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                        </form>
                                    <?php } ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody id="sort-list">

                            <?php
                            if ($parent_id > 0) {
                                ?>

                                <tr class="sortno">
                                    <td  class="sortleft-m"><div></div></td>
                                    <td colspan="2" align="left">

                                        <!-- Категории "ВВЕРХ" -->
                                        <form>
                                            <div>
                                                <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                                <button name="parent_up" value="<?php echo $parent_id ?>" class="btn btn-default btn-xs" title="" action="index.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                            </div>
                                        </form>

                                    </td>
                                </tr>

                                <?php
                            }
                            $transfer = 0;
                            for ($start; $start < $finish; $start++) {
                                $transfer++;

                                if ($start < $count_lines_cat) {
                                    ?>

                                    <tr class="sort-list" unitid="<?php echo $arr_merge['cat'][$start][0] ?>">

                                        <!-- Вырезанные категории "АКТИВНЫЕ" -->
                                        <?php if (isset($_SESSION['buffer']['cat']) == true && in_array($arr_merge['cat'][$start][0], $_SESSION['buffer']['cat']) == true && $arr_merge['cat'][$start][3] == 1) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-primary btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Вырезанные категории "НЕ АКТИВНЫЕ" -->
                                        <?php } elseif (isset($_SESSION['buffer']['cat']) == true && in_array($arr_merge['cat'][$start][0], $_SESSION['buffer']['cat']) == true && $arr_merge['cat'][$start][3] == 0) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-folder-open"> </span></a></div></td>

                                            <!-- Категория для трансфера -->
                                        <?php } elseif ($transfer == $lines_on_page + 1) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-primary btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-transfer"> </span></a></div></td>

                                            <!-- Если категория НЕ АКТИВНА -->
                                        <?php } elseif ($arr_merge['cat'][$start][3] == 0) { ?>
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft">

                                                <!-- Неактивная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                                        <button name="parent_down" value="<?php echo $arr_merge['cat'][$start][0] ?>" class="btn btn-default btn-xs" title="<?php echo $arr_merge['cat'][$start][1] ?>" action="index.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>

                                            <?php
                                        } else {
                                            ?>
                                            <!-- Если категория АКТИВНА -->
                                            <td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>    
                                            <td class="sortleft">

                                                <!-- Активная категория "ВНИЗ" -->
                                                <form>
                                                    <div>
                                                        <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                                        <button name="parent_down" value="<?php echo $arr_merge['cat'][$start][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $arr_merge['cat'][$start][1] ?>" action="index.php" formmethod="get"><span class="glyphicon glyphicon-folder-open"> </span></button>
                                                    </div>
                                                </form>

                                            </td>
                                            <?php
                                        }
                                        ?>

                                        <!-- ВЫБРАННЫЕ СТРОКИ -->
                                        <td class="option" id="<?php echo $arr_merge['cat'][$start][0] ?>"><span class="inactive" style="display: none;"></span>
                                            <?php if ($transfer == $lines_on_page + 1) { ?>
                                                <div class="transfer" id="<?php echo $arr_merge['cat'][$start][0] ?>"><?php echo lang('categories_transfer') ?></div>
                                            <?php } else { ?>
                                                <div class="context-one" id="<?php echo $arr_merge['cat'][$start][0] ?>"><?php echo $arr_merge['cat'][$start][1] ?></div>
                                            <?php } ?>
                                        </td>	
                                        <td class="sortleft-m"></td>
                                    </tr>

                                    <?php
                                }

                                // ВЫВОДИМ ТОВАРЫ
                                if ($start >= $count_lines_cat && $transfer < $lines_on_page + 1) {
                                    ?>
                                    <tr class="sort-list">

                                        <!-- Вырезанные товары "АКТИВНЫЕ" -->
                                        <?php if (isset($_SESSION['buffer']['prod']) == true && in_array($arr_merge['prod'][$start . 'a'][0], $_SESSION['buffer']['prod']) == true && $arr_merge['prod'][$start . 'a'][3] == 1) { ?>
                                            <td class="sortleft-m"></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-success btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>

                                            <!-- Вырезанные товары "НЕ АКТИВНЫЕ" -->
                                        <?php } elseif (isset($_SESSION['buffer']['prod']) == true && in_array($arr_merge['prod'][$start . 'a'][0], $_SESSION['buffer']['prod']) == true && $arr_merge['prod'][$start . 'a'][3] == 0) { ?>
                                            <td class="sortleft-m"></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>

                                            <!-- Если товар НЕ АКТИВЕН -->
                                        <?php } elseif ($arr_merge['prod'][$start . 'a'][3] == 0) { ?>
                                            <td class="sortleft-m"></td>    
                                            <td class="sortleft"><div><a href="#" class="btn btn-default btn-xs" role="button" aria-disabled="true"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>
                                        <?php } else { ?>

                                            <!-- Если товар АКТИВЕН -->    
                                            <td class="sortleft-m"></td>
                                            <td class="sortleft"><div><a href="#" class="btn btn-success btn-xs" role="button" aria-disabled="true"><span class="glyphicon glyphicon-shopping-cart"> </span></a></div></td>
                                            <!-- ВЫБРАННЫЕ СТРОКИ -->
                                        <?php } ?>
                                        <td class="context-one option" id="product_<?php echo $arr_merge['prod'][$start . 'a'][0] ?>"><span class="inactive" style="display: none;"></span>
                                            <div class="pull-left"><?php echo $arr_merge['prod'][$start . 'a'][1] ?></div>
                                            <div class="pull-right"><?php echo \eMarket\Ecb::priceInterface($arr_merge['prod'][$start . 'a'], 1) ?></div>
                                        </td>
                                        <?php if ($arr_merge['prod'][$start . 'a'][4] != '' && $arr_merge['prod'][$start . 'a'][4] != NULL && strpos($arr_merge['prod'][$start . 'a'][4], ',') == FALSE && \eMarket\Modules\Discount\Sale::status() == 1) { ?>
                                            <td class="sortleft"><span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="<?php echo \eMarket\Set::productSaleTooltip($arr_merge['prod'][$start . 'a'][4]) ?>" class="glyphicon glyphicon-tag text-primary"> </span></td>
                                        <?php } elseif ($arr_merge['prod'][$start . 'a'][4] != '' && $arr_merge['prod'][$start . 'a'][4] != NULL && strpos($arr_merge['prod'][$start . 'a'][4], ',') != FALSE && \eMarket\Modules\Discount\Sale::status() == 1) { ?>
                                            <td class="sortleft"><span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="<?php echo \eMarket\Set::productSaleTooltip($arr_merge['prod'][$start . 'a'][4]) ?>" class="glyphicon glyphicon-tags text-primary"> </span></td>

                                        <?php } else { ?>
                                            <td class="sortleft-m"><span class="glyphicon glyphicon-tag"> </span></td>
                                        <?php } ?>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <?php
            } elseif ($lines_cat == FALSE && $parent_id > 0) {
                ?>

                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <div><?php echo lang('no_listing') ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="sortno">
                                <td  class="sortleft-m"></td>
                                <td class="sortleft">

                                    <!-- Категорий нет "ВВЕРХ" -->
                                    <form>
                                        <div>
                                            <input hidden name="route" value="<?php echo \eMarket\Valid::inGET('route') ?>">
                                            <button name="parent_up" value="<?php echo $parent_id ?>" class="btn btn-default btn-xs" title="" action="index.php" formmethod="get"><span class="glyphicon glyphicon-option-horizontal"></span></button>
                                        </div>
                                    </form>

                                </td>
                                <td class="options"><div class="context-one"><?php echo lang('no_listing') ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <div><?php echo lang('no_listing') ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  class="sortleft-m"></td>
                                <td class="sortleft"></td>
                                <td class="options"><div class="context-one"><?php echo lang('no_listing') ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
