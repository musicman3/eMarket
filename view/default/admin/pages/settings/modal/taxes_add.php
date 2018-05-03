<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Налог" -->
<div id="taxes_add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Формат поля: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title">Налоги</h4>
            </div>
            <form id="form_taxes" name="form_taxes" action="javascript:void(null);" onsubmit="call_taxes()" method="post" enctype="multipart/form-data">
                <div class="panel-body">

                    <!-- Языковые панели -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#<?php echo $lang_all[0] ?>"><img src="/view/default/admin/images/langflags/<?php echo $lang_all[0] ?>.png" alt="<?php echo $lang_all[0] ?>" title="<?php echo $lang_all[0] ?>" width="16" height="10" /> <?php echo $lang['menu_language'] ?></a></li>

                        <?php
                        if (count($lang_all) > 1) {
                            for ($xl = 1; $xl < count($lang_all); $xl++) {

                                ?>

                                <li><a data-toggle="tab" href="#<?php echo $lang_all[$xl] ?>"><img src="/view/default/admin/images/langflags/<?php echo $lang_all[$xl] ?>.png" alt="<?php echo $lang_all[$xl] ?>" title="<?php echo $lang_all[$xl] ?>" width="16" height="10" /> <?php echo $lang_all[$xl] ?></a></li>

                                <?php
                            }
                        }

                        ?>

                    </ul>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo $lang_all[0] ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <label><?php echo $lang['name'] ?>:</label><br>
                                <input class="input-sm form-control" type="text" name="<?php echo $lang_all[0] ?>" />
                            </div>
                        </div>

                        <?php
                        if (count($lang_all) > 1) {
                            for ($xl = 1; $xl < count($lang_all); $xl++) {

                                ?>

                                <div id="<?php echo $lang_all[$xl] ?>" class="tab-pane fade">
                                    <div class="form-group">
                                        <label><?php echo $lang['name'] ?>:</label><br>
                                        <input class="input-sm form-control" type="text" name="<?php echo $lang_all[$xl] ?>" />
                                    </div>
                                </div>

                                <?php
                            }
                        }

                        ?>
                        <div class="form-group">
                            <label>Ставка налога (%): </label><br>
                            <div class="input-group">
                            <span class="input-group-addon" id="rate1">%</span>
                            <input class="input-sm form-control" placeholder="Введите значение" aria-describedby="rate1" type="text" name="rate" id="rate" />
                        </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-save"></span> <?php echo $lang['save'] ?></button>
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $lang['cancel'] ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function call_taxes() {
        var msg = $('#form_taxes').serialize();
        $.ajax({
            type: 'POST',
            url: '/controller/admin/pages/settings/taxes.php',
            data: msg,
            success: function (data) {
                $('#taxes_add').modal('hide');
                document.location.reload(false);
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->