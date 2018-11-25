<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="basic" class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><?php echo lang('title_basic_settings_index') ?></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2"><?php echo lang('lines_on_page') ?></label>
                        <div class="col-sm-10">
                            <input type="" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Опция 2</label>
                        <div class="col-sm-5">
                            <select class="form-control">
                                <option>Выбор</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Опция 3</label>
                        <div class="col-sm-1">
                            <input type="checkbox">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>