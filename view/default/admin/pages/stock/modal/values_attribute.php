<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Значения атрибута" -->
<div id="values_attribute" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку категорий" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 id="title_values_attribute" class="modal-title"></h4>
            </div>

            <div class="panel-body">
                <div class="tab-content">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="1"></th>
                                <th>
                                    <div class="b-right"><button type="button" class="add-values-attribute btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span></button></div>
                                </th>
                            </tr>

                        </thead>

                        <tbody class="values_attribute"></tbody>

                    </table>

                    <div class="modal-footer">
                        <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                        <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Значения атрибута" -->
