<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="basic" class="container-fluid">
    <div class="row-fluid">
        <div class="panel panel-default">

            <div class="panel-heading">
                <!--Выводим уведомление об успешном действии-->
                <?php $MESSAGES->alert(); ?>
                <h3 class="panel-title">
                    <div class="pull-left"><a class="btn btn-primary btn-xs" href="../"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_' . $SET->titleDir() . '_index') ?></div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <form id="form_add" name="form_add" class="form-horizontal" action="javascript:void(null);" onsubmit="callAdd()">
                <div class="panel-body">
                    <input hidden name="add" value="ok">

                    <div class="form-group">
                        <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('lines_on_page') ?></label></div>
                        <div class="col-sm-9">
                            <input type="text" name="lines_on_page" class="form-control" value="<?php echo $SET->linesOnPage() ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3 text-left"><label class=""><?php echo lang('session_expr_time') ?> <span data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('session_expr_time_help') ?>" class="glyphicon glyphicon-question-sign"></span></label></div>
                        <div class="col-sm-9">
                            <input type="text" name="session_expr_time" class="form-control" value="<?php echo $SET->sessionExprTime() ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3 text-left"><label class="control-label"><button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button></label></div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>