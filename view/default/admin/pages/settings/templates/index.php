<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>



<div id="settings_templates" class="container-fluid hidden-sm hidden-xs">
    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><a class="btn btn-primary btn-xs" href="../"><span class="back glyphicon glyphicon-share-alt"></span></a> Шаблон</div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-center connectedSortable" colspan="3" id="sortable2">Навигация</td>
                            <td class="text-center connectedSortable" rowspan="4" id="sortable1">Модули

                                <div id="1" class="text-center">Item 1</div>
                                <div id="2" class="text-center">Item 2</div>
                                <div id="3" class="text-center">Item 3</div>
                                <div id="4" class="text-center">Item 4</div>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-center connectedSortable" colspan="3" id="sortable3">Хедер</td>
                        </tr>
                        <tr>
                            <td class="text-center connectedSortable" id="sortable4">Левый</td>
                            <td class="text-center connectedSortable" id="sortable5">Центр</td>
                            <td class="text-center connectedSortable" id="sortable6">Правый</td>
                        </tr>
                        <tr>
                            <td class="text-center connectedSortable" colspan="3" id="sortable7">Футер</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="settings_templates" class="container-fluid visible-sm visible-xs">
    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left">Шаблон</div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                На планшетах и смартфонах не доступно
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#sortable1, #sortable2, #sortable3, #sortable4, #sortable5, #sortable6, #sortable7").sortable({
            connectWith: ".connectedSortable",
            stop: function (event, div) {
                var arrList2 = $('#sortable2 div').map(function () {
                    return $(this).attr('id');
                }).get();

                var arrList3 = $('#sortable3 div').map(function () {
                    return $(this).attr('id');
                }).get();
                //alert(arrList3);
            }
        }).disableSelection();
    });
</script>