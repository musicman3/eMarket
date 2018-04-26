<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Налог" -->
<div id="taxes_add" class="products modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Налоги</h4>
            </div>
            <form id="form_taxes" name="form_taxes" action="javascript:void(null);" onsubmit="call_taxes()" method="post" enctype="multipart/form-data">
                <div class="panel-body">

                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели основное -->
                        <div id="panel1" class="tab-pane fade in active">

                            <!-- Языковые панели -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#Russian"><img src="/view/default/admin/images/worldflags/ru.png" alt="Russian" title="Russian" width="16" height="10" /> Russian</a></li>
                                <li><a data-toggle="tab" href="#English"><img src="/view/default/admin/images/worldflags/us.png" alt="English" title="English" width="16" height="10" /> English</a></li>
                            </ul>

                            <!-- Содержимое языковых панелей -->
                            <div class="tab-content">
                                <div id="Russian" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <label><?php echo $lang['name'] ?>:</label><br>
                                        <input class="input-sm form-control" type="text" name="name" id="name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Ставка налога (%):</label><br>
                                        <input class="input-sm form-control" type="text" name="rate" id="rate" />
                                    </div>
                                </div>
                                <div id="English" class="tab-pane fade">
                                    <div class="form-group">
                                        <label><?php echo $lang['name'] ?>:</label><br>
                                        <input class="input-sm form-control" type="text" name="name" id="name" />
                                    </div>
                                    <div class="form-group">
                                        <label>Ставка налога (%):</label><br>
                                        <input class="input-sm form-control" type="text" name="rate" id="rate" />
                                    </div>
                                </div>
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
            url: '/controller/admin/pages/settings/settings.php',
            data: msg,
            success: function (data) {
                $('#taxes_add').remove();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $('#ajax').html(data);
            }
        });
    }
</script>
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->