<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Корзина" -->
<div id="cart" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>

            <div class="panel-body">

                <div id="accordions" class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title"><a data-parent="#accordions" data-toggle="collapse" class="accordion-toggle" href="#collapse-devilery">Способ доставки <span class="glyphicon glyphicon-triangle-bottom"></span></a></h6>
                        </div>
                        <div class="panel-collapse collapse" id="collapse-devilery">
                            <div class="panel-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio">
                                    <label class="form-check-label">Энергия</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title"><a data-parent="#accordions" data-toggle="collapse" class="accordion-toggle" href="#collapse-checkout">Способ оплаты <span class="glyphicon glyphicon-triangle-bottom"></span></a></h6>
                        </div>
                        <div class="panel-collapse collapse" id="collapse-checkout">
                            <div class="panel-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio">
                                    <label class="form-check-label">В пункте самовывоза</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#cart"><span class="glyphicon glyphicon-ok"></span> Завершить</button>
            </div>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Корзина" -->