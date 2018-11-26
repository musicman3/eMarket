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

            <form class="form-horizontal" id="form" name="form" action="index.php" method="post" enctype="multipart/form-data">
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-sm-2"><?php echo lang('lines_on_page') ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="lines_on_page" class="form-control" value="<?php echo $lines_on_page ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2"><?php echo lang('session_expr_time') ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="session_expr_time" class="form-control" value="<?php echo $session_expr_time ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>