<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="error_log" class="container-fluid">
    <div class="panel panel-default">

        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <?php \eMarket\Messages::alert(); ?>
            <h3 class="panel-title">
                <div class="pull-left"><?php echo \eMarket\Set::titlePageGenerator() ?></div>
                <div class="clearfix"></div>
            </h3>
        </div>
        <?php if (file_exists(ROOT . '/model/work/errors.log') == true) { ?>
            <div class="panel-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <div class="page"><?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo $count_lines; ?> )</div>
                            </th>

                            <th>

                                <form id="form_delete_log" name="form_delete_log" action="javascript:void(null);" onsubmit="callDelete('_log')" enctype="multipart/form-data">
                                    <input hidden name="delete" value="delete">
                                    <div class="b-right"><button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>
                                </form>

                                <?php if ($count_lines > $lines_on_page) { ?>
                                    <form>
                                        <input hidden name="start" value="<?php echo $start ?>">
                                        <input hidden name="finish" value="<?php echo $finish ?>">
                                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>

                                    <form>
                                        <input hidden name="backstart" value="<?php echo $start ?>">
                                        <input hidden name="backfinish" value="<?php echo $finish ?>">
                                        <div class="b-left"><button type="submit" class="btn btn-primary btn-xs" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </form>
                                <?php } ?>

                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        for ($start; $start < $finish; $start++) {

                            if (isset($lines[$start]) == TRUE) {

                                if (strrpos($lines[$start], 'PHP Notice:') == TRUE) {
                                    ?><tr class="success"><td colspan="2"><?php echo $lines[$start] . '</td></tr>'; ?><?php
                                } elseif
                                (strrpos($lines[$start], 'PHP Warning:') == TRUE) {
                                    ?><tr class="warning"><td colspan="2"><?php echo $lines[$start] . '</td></tr>'; ?><?php
                                } elseif
                                (strrpos($lines[$start], 'PHP Catchable fatal error:') == TRUE) {
                                    ?><tr class="danger"><td colspan="2"><?php echo $lines[$start] . '</td></tr>'; ?><?php
                                        } elseif
                                        (strrpos($lines[$start], 'PHP Fatal error:') == TRUE) {
                                            ?><tr class="danger"><td colspan="2"><?php echo $lines[$start] . '</td></tr>'; ?><?php
                                        } elseif
                                        (strrpos($lines[$start], 'PHP Parse error:') == TRUE) {
                                            ?><tr class="info"><td colspan="2"><?php echo $lines[$start] . '</td></tr>'; ?><?php } else {
                                            ?><tr><td colspan="2"><?php
                                            echo $lines[$start] . '</td></tr>';
                                        }
                                    }
                                }
                                ?>

                    </tbody>

                </table>

            </div>
                                    <?php } else { ?>
            <div class="panel-body"><?php echo lang('no_listing') ?></div>
<?php } ?>
    </div>
</div>