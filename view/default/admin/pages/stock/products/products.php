<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<!-- Настройка TinyMCE" -->
<script type="text/javascript" language="javascript">
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink visualblocks visualchars fullscreen lists charmap imagetools hr textcolor table link image wordcount code media preview',
        toolbar1: 'undo redo | bold italic underline strikethrough backcolor forecolor | alignleft aligncenter alignright alignjustify | outdent indent bullist numlist hr | visualchars visualblocks ',
        toolbar2: 'fontselect fontsizeselect formatselect superscript removeformat | charmap link unlink image media table | code preview fullscreen',
        language: '<?php echo lang('meta-language') ?>',
        toolbar_items_size: 'small',
        menubar: false,
    });
</script>

<!-- Настройка Datepicker" -->
<script type="text/javascript" language="javascript">
    $(function () {
    $( "#date_available" ).datepicker({
      showOtherMonths: true,
      showAnim: 'fadeIn',
      duration: 'normal',
      showWeek: true,
      selectOtherMonths: true
    });
  } );
</script>

<!-- Модальное окно "Добавить товар" -->
<?php require_once('modal/products_add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить товар" -->

<div id="ajax">
    <div id="products" class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left"><?php echo lang('title_products_index') ?></div>
                        <form action="/controller/admin/pages/stock/products/products.php" method="post" class="form-inline">
                            <div class="add-xs"><?php echo lang('rows_page') ?>: <select name="select_row" class="input-xs form-control" onchange="this.form.submit()">
                                    <option>(<?php echo $lines_of_page ?>)</option>
                                    <option>20</option>
                                    <option>35</option>
                                    <option>50</option>
                                    <option>75</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <div class="page"><?php echo lang('s') ?> <?php echo $start + 1 ?> <?php echo lang('po') ?> <?php echo $finish ?> ( <?php echo lang('iz') ?> <?php echo $count_lines; ?> )</div>
                                    <div class="right"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    <div class="left"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                </th>
                            <tr class="border">
                                <th align="left"><div style="width: 14px;"></div></th>
                                <th align="left"><div style="width: 24px;"></div></th>
                                <th class="pleft al-text" align="left">Название</th>
                                <th class="pright al-text" align="left">Модель</th>
                                <th class="pright al-text" align="left">Ед. изм.</th>
                                <th class="pright al-text" align="left">Кол-во</th>
                                <th class="pright al-text" align="left">Цена</th>
                            </tr>
                        </thead>
                    </table>
                    <table class="table table-hover">
                        <tbody id="sort-list">
                            <tr class="sortno">
                                <td class="sortleft-mp" align="left"><a href="#" class="btn btn-default btn-xs disabled" role="button" aria-disabled="true">.</a></td>
                                <td colspan="6" align="left"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-option-horizontal"></span></button></td>
                            </tr>
                            <tr class="sort-list">
                                <td class="sortyes sortleft-m" align="left"><span class="glyphicon glyphicon-move"> </span></td>    
                                <td class="sortleft" align="left"><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-folder-open"> </span></button></td>
                                <td class="pleft option" align="left">
                                    <div class="context-one">Название товара пишем вот таким длинным для проверки длинны названия и колонок таблиц
                                    </div>
                                </td>
                                <td class="pright al-text" align="left">MD34-50</td>
                                <td class="pright al-text" align="left">шт.</td>
                                <td class="pright al-text" align="left">5</td>
                                <td class="pright al-text" align="left">1200.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
