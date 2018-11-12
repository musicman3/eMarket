<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('zone') ?></h4>
            </div>
            <form id="form" name="form" action="index.php" method="post" enctype="multipart/form-data">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />
                    <input hidden name="zone_id" value="<?php echo $zones_id ?>">

                    <!--Мультиселект-->
                    <span class="multiselect-native-select">
                        <select id="example-xss-html-collapseOptGroupsByDefault-buttonText-selectAllText-filterPlaceholder-collapsedClickableOptGroups-enableFiltering-enableCaseInsensitiveFiltering-includeSelectAllOption" name="multiselect[]" multiple="multiple">
                            <?php
                            $z = 0;
                            foreach ($countries_multiselect as $k => $v) {
                                if (in_array(array($k), $lines) == TRUE && count($regions[0][1]) > 0){
                                ?>
                                <optgroup label="<span style='color:#4caf50'><?php echo $v ?></span>">
                                    <?php
                                }else{ ?>
                                    <optgroup label="<?php echo $v ?>">
                                    <?php
                                }
                                    foreach ($FUNC->filter_array_to_key($regions_multiselect, 1, $k, 2) as $k2 => $v2) {
                                        // Если Страна уже добавлена, то отмечаем галочкой в селекте
                                        if (in_array(array($k), $lines) == TRUE && $k2 == $regions[$z][1]) {
                                            $z++;

                                            ?>
                                            <!--Возвращаем массив формата country_id => id Региона -->
                                            <option value="<?php echo $k ?>-<?php echo $k2 ?>" selected="selected"><?php echo $v2 ?></option>
                                            <?php
                                            //Если Страна не была добавлена, то выводим стандартно
                                        } else {

                                            ?>
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

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- КОНЕЦ Модальное окно "Добавить" -->