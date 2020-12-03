<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div>
    <div id="ajax" class="container-fluid">
        <div class="panel panel-default">

            <div class="panel-heading">
                <!--Выводим уведомление об успешном действии-->
                <?php \eMarket\Messages::alert(); ?>
                <h3 class="panel-title">
                    <?php echo \eMarket\Set::titlePageGenerator() ?>
                </h3>
            </div>
            <?php if (file_exists(ROOT . '/model/work/errors.log') == true) { ?>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <?php echo lang('with') ?> <?php echo $start + 1 ?> <?php echo lang('to') ?> <?php echo $finish ?> ( <?php echo lang('of') ?> <?php echo $count_lines; ?> )
                                    </th>

                                    <th>
                                        <div class="flexbox">
                                            <form id="form_delete_log" name="form_delete_log" action="javascript:void(null);" onsubmit="Ajax.callDelete('_log')" enctype="multipart/form-data">
                                                <input hidden name="delete" value="delete">
                                                <div class="b-left"><button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-placement="left" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="glyphicon glyphicon-trash"> </span></button></div>
                                            </form>
                                            <form>
                                                <input hidden name="backstart" value="<?php echo $start ?>">
                                                <input hidden name="backfinish" value="<?php echo $finish ?>">
                                                <div class="b-left">
                                                    <?php if ($start > 0) { ?>
                                                        <button type="submit" class="btn btn-primary btn-xs" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                                    <?php } else { ?>
                                                        <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                            <form>
                                                <input hidden name="start" value="<?php echo $start ?>">
                                                <input hidden name="finish" value="<?php echo $finish ?>">
                                                <div>
                                                    <?php if ($finish != $count_lines) { ?>
                                                        <button type="submit" class="btn btn-primary btn-xs" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                                    <?php } else { ?>
                                                        <a type="submit" class="btn btn-primary btn-xs disabled"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        </div>
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
                </div>
            <?php } else { ?>
                <div class="panel-body"><?php echo lang('no_listing') ?></div>
            <?php } ?>
        </div>
    </div>
</div>