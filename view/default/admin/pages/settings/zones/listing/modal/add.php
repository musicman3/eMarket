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
            <form id="form" name="form" action="javascript:void(null);" onsubmit="call()" method="get" enctype="multipart/form-data">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />

                    <!--Мультиселект-->
                    <span class="multiselect-native-select">
                        <select id="example-collapseOptGroupsByDefault-buttonText-selectAllText-filterPlaceholder-collapsedClickableOptGroups-enableFiltering-enableCaseInsensitiveFiltering-includeSelectAllOption" name="multiselect[]" multiple="multiple">
                            <?php for ($c = 1; $c < count($countries_multiselect) + 1; $c++) { ?>
                                <optgroup label="<?php echo $countries_multiselect[$c] ?>">

                                    <?php for ($d = 1; $d < count(array_keys($regions_multiselect, $c)); $d++) { ?>
                                        <option value="<?php echo $c ?>-<?php echo $d ?>"><?php echo array_keys($regions_multiselect, $c)[$d] ?></option>
                                    <?php } ?>

                                </optgroup>
                            <?php } ?>

                        </select>
                    </span>
                    <!--КОНЕЦ Мультиселект-->

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function call() {
        var msg = $('#form').serialize();
        $.ajax({
            type: 'GET',
            url: 'index.php',
            data: msg,
            success: function (data) {
                $('#add').modal('hide');
                location.href = 'index.php';
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Добавить" -->