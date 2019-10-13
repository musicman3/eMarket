<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_'. \eMarket\Core\Set::titleDir() .'_index') ?></h4>
            </div>
            <form id="form" name="form" onsubmit="$('.modal').modal('hide')" method="post" enctype="multipart/form-data">

                <div class="modal-footer">
                    <input hidden name="route" value="settings/zones/listing">
                    <input type="hidden" name="add" value="ok" />
                    <input hidden name="zone_id" value="<?php echo $zones_id ?>">

                    <!--Мультиселект-->
                    <span class="multiselect-native-select">
                        <select id="example-selectAllJustVisible-buttonClass-buttonTitle-xss-html-collapseOptGroupsByDefault-buttonText-selectAllText-filterPlaceholder-collapsedClickableOptGroups-enableFiltering-enableCaseInsensitiveFiltering-includeSelectAllOption" name="multiselect[]" multiple="multiple">
                            <?php
                            $count = 0;
                            foreach ($countries_multiselect as $k => $v) {
                                // Если в Стране уже есть выделенные ранее регионы
                                if (in_array(array($k), $lines) == TRUE && count($regions) != 0) {

                                    ?>
                                    <!-- то выводим их с подсветкой -->
                                    <optgroup label="<span class='multiselect-add'><?php echo $v ?></span>">
                                    <?php } else {

                                        ?>
                                        <!-- если их нет, то стандартный вывод -->
                                    <optgroup label="<?php echo $v ?>">
                                        <?php
                                    }
                                    foreach (\eMarket\Other\Func::filterArrayToKey($regions_multiselect, 1, $k, 2) as $k2 => $v2) {
                                        // Если Страна уже добавлена
                                        if (in_array(array($k), $lines) == TRUE && isset($regions[$count][1]) == TRUE && $k2 == $regions[$count][1]) {
                                            $count++;

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