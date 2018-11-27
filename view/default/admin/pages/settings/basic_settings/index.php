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
                    <div class="pull-left"><a class="btn btn-primary btn-xs" href="../"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_' . $TITLE_DIR . '_index') ?></div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <form id="form" name="form" action="index.php" method="post" enctype="multipart/form-data">
                <div class="panel-body">

                    <div class="input-group">
                        <span class="input-group-addon"><?php echo lang('lines_on_page') ?></span>
                        <input type="text" name="lines_on_page" class="form-control" value="<?php echo $lines_on_page ?>">
                    </div>
                    </br>
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo lang('session_expr_time') ?> <span data-toggle="tooltip" data-placement="left" data-original-title="<?php echo lang('session_expr_time_help') ?>" class="glyphicon glyphicon-question-sign"></span></span>
                        <input type="text" name="session_expr_time" class="form-control" value="<?php echo $session_expr_time ?>">
                    </div>
                    </br>
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>