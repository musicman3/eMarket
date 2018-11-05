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

                    <!-- Build your select: -->


                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#example-enableCollapsibleOptGroups-enableClickableOptGroups-enableFiltering-includeSelectAllOption').multiselect({
                                enableClickableOptGroups: true,
                                enableCollapsibleOptGroups: true,
                                enableFiltering: true,
                                includeSelectAllOption: true
                            });
                        });
                    </script>
                    
                    <span class="multiselect-native-select"><select id="example-enableCollapsibleOptGroups-enableClickableOptGroups-enableFiltering-includeSelectAllOption" multiple="multiple">
                            <optgroup label="Group 1">
                                <option value="1-1" disabled="">Option 1.1</option>
                                <option value="1-2" selected="selected">Option 1.2</option>
                                <option value="1-3" selected="selected">Option 1.3</option>
                            </optgroup>
                            <optgroup label="Group 2">
                                <option value="2-1">Option 2.1</option>
                                <option value="2-2">Option 2.2</option>
                                <option value="2-3">Option 2.3</option>
                            </optgroup>
                        </select>
                        
                        <div class="btn-group open">
                            
                            <button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="Option 1.2, Option 1.3" aria-expanded="true">
                                <span class="multiselect-selected-text">Option 1.2, Option 1.3</span> <b class="caret"></b>
                            </button>
                            
                            <ul class="multiselect-container dropdown-menu">
                                <li class="multiselect-item multiselect-filter" value="0">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                        <input class="form-control multiselect-search" type="text" placeholder="Search">
                                        
                                        <button class="btn btn-default multiselect-clear-filter" type="button">
                                                <i class="glyphicon glyphicon-remove-circle"></i>
                                        </button>
                                       
                                    </div>
                                </li>
                                <li class="multiselect-item multiselect-all" style="background: rgb(243, 243, 243) none repeat scroll 0% 0%; border-bottom: 1px solid rgb(234, 234, 234);">
                                    <a tabindex="0" class="multiselect-all">
                                        <label class="checkbox" style="padding: 3px 20px 3px 35px;">
                                            <input type="checkbox" value="multiselect-all">  Select all</label>
                                    </a>
                                </li>
                                <li class="multiselect-item multiselect-group active">
                                    <a href="javascript:void(0);">
                                        <label>
                                            <input type="checkbox" value="undefined">
                                            <b> Group 1</b>
                                        </label>
                                        <span class="caret-container">
                                            <b class="caret"></b>
                                        </span>
                                    </a>
                                </li>
                                <li class="disabled"><a tabindex="-1">
                                        <label class="checkbox" title="Option 1.1">
                                            <input type="checkbox" value="1-1" disabled=""> Option 1.1</label>
                                    </a>
                                </li>
                                <li class="active">
                                    <a tabindex="0">
                                        <label class="checkbox" title="Option 1.2">
                                            <input type="checkbox" value="1-2"> Option 1.2</label>
                                    </a>
                                </li>
                                <li class="active">
                                    <a tabindex="0">
                                        <label class="checkbox" title="Option 1.3">
                                            <input type="checkbox" value="1-3"> Option 1.3</label>
                                    </a>
                                </li>
                                <li class="multiselect-item multiselect-group">
                                    <a href="javascript:void(0);">
                                        <label>
                                            <input type="checkbox" value="undefined">
                                            <b> Group 2</b>
                                        </label>
                                        <span class="caret-container">
                                            <b class="caret"></b>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a tabindex="0"><label class="checkbox" title="Option 2.1">
                                            <input type="checkbox" value="2-1"> Option 2.1</label>
                                    </a>
                                </li>
                                <li>
                                    <a tabindex="0">
                                        <label class="checkbox" title="Option 2.2">
                                            <input type="checkbox" value="2-2"> Option 2.2</label>
                                    </a>
                                </li>
                                <li>
                                    <a tabindex="0">
                                        <label class="checkbox" title="Option 2.3">
                                            <input type="checkbox" value="2-3"> Option 2.3</label>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </span>



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

<!--Мультиселект-->
<!-- Initialize the plugin: -->






