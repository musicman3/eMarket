<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Core\Settings::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">

                <div class="modal-footer">
                    <input hidden name="route" value="settings/zones/listing">
                    <input type="hidden" name="add" value="ok" />
                    <input hidden name="zone_id" value="<?php echo \eMarket\Admin\ZonesListing::$zones_id ?>">

                    <!--Мультиселект-->
                    <span class="multiselect-native-select">
                        <select id="multiselect" name="multiselect[]" multiple="multiple">
                            <?php
                            foreach (\eMarket\Admin\ZonesListing::$countries_multiselect as $k => $v) {
                                // Если в Стране уже есть выделенные ранее регионы
                                if (in_array(array($k), \eMarket\Admin\ZonesListing::$lines) == TRUE && count(\eMarket\Admin\ZonesListing::$regions) != 0) {
                                    ?>
                                    <!-- то выводим их с подсветкой -->
                                    <optgroup label="<span class='multiselect-add'><?php echo $v ?></span>">
                                    <?php } else {
                                        ?>
                                        <!-- если их нет, то стандартный вывод -->
                                    <optgroup label="<?php echo $v ?>">
                                        <?php
                                    }
                                    foreach (\eMarket\Core\Func::filterArrayToKeyAssoc(\eMarket\Admin\ZonesListing::$regions_multiselect, 'country_id', $k, 'name', 'id') as $k2 => $v2) {
                                        // Если Страна уже добавлена
                                        if (in_array(array($k), \eMarket\Admin\ZonesListing::$lines) == TRUE && isset(\eMarket\Admin\ZonesListing::$regions[\eMarket\Admin\ZonesListing::$count]['regions_id']) == TRUE && $k2 == \eMarket\Admin\ZonesListing::$regions[\eMarket\Admin\ZonesListing::$count]['regions_id']) {
                                            \eMarket\Admin\ZonesListing::$count++;
                                            ?>
                                            <!--то отмечаем галочкой в селекте и возвращаем массив формата country_id => id Региона -->
                                            <option value="<?php echo $k ?>-<?php echo $k2 ?>" selected="selected"><?php echo $v2 ?></option>
                                            <?php
                                        } else { //Если Страна не была добавлена
                                            ?>
                                            <!--то выводим стандартно и возвращаем массив формата country_id => id Региона -->
                                            <option value="<?php echo $k ?>-<?php echo $k2 ?>"><?php echo $v2 ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </span>
                    <!--КОНЕЦ Мультиселект-->

                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Добавить" -->