<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="panel-body">

    <div class="pull-right">
	<input hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="ВКЛ." data-off-text="ВЫКЛ." name="switch" checked>
    </div>
    <div class="pull-left">
	<div class="text-left">Модуль оплаты ВасяПэй</div>
	<div class="text-left">Автор: Вася Пупкин</div>
	<div class="text-left">Версия: 1.0</div>
    </div>
    <div class="clearfix"></div>
    </br>
    <div class="form-group">
        <div class="input-group has-error">
            <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
            <input class="input-sm form-control" placeholder="<?php echo lang('value') ?>" type="text" pattern="\d+(\.\d{0,7})?" name="value_length" id="value_length" required />
        </div>
    </div>

</div>