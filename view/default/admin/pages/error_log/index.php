<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<div id="log" class="container">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><?php echo $lang['title_error_log'] ?></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <?php if (file_exists($VALID->inSERVER('DOCUMENT_ROOT') . '/model/work/errors.log') == true) { ?>
                <div class="panel-body">
                    <!--<div class="table-responsive">-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="page"><?php echo $lang['s'] ?> <?php echo $i + 1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )</div>
                                </th>

                                <th>

                                    <form>
                                        <?php if ($counter > $lines_page) { ?>
                                            <input hidden name="i" value="<?php echo $i ?>">
                                            <input hidden name="lines_p" value="<?php echo $lines_p ?>">
                                        <?php } ?>
                                        <div class="right"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>

                                    <form>
                                        <?php if ($counter > $lines_page) { ?>
                                            <input hidden name="i2" value="<?php echo $i ?>">
                                            <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
                                        <?php } ?>
                                        <div class="left"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </form>



                                    <form>
                                        <input hidden name="delete" value="delete">
                                        <div class="left"><button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo $lang['confirm-yes'] ?>" data-btn-cancel-label="<?php echo $lang['confirm-no'] ?>" title="<?php echo $lang['confirm-del'] ?>" action="index.php" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div>
                                    </form>

                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            for ($i; $i < $lines_p; $i++) {

                                if (strrpos($lines[$i], 'PHP Notice:') == true) {

                                    ?><tr class="success"><td colspan="2"><?php echo $lines[$i] . '</td></tr>'; ?><?php
                                } elseif
                                (strrpos($lines[$i], 'PHP Warning:') == true) {

                                    ?><tr class="warning"><td colspan="2"><?php echo $lines[$i] . '</td></tr>'; ?><?php
                                        } elseif
                                        (strrpos($lines[$i], 'PHP Catchable fatal error:') == true) {

                                            ?><tr class="danger"><td colspan="2"><?php echo $lines[$i] . '</td></tr>'; ?><?php
                                        } elseif
                                        (strrpos($lines[$i], 'PHP Fatal error:') == true) {

                                            ?><tr class="danger"><td colspan="2"><?php echo $lines[$i] . '</td></tr>'; ?><?php
                                        } elseif
                                        (strrpos($lines[$i], 'PHP Parse error:') == true) {

                                            ?><tr class="info"><td colspan="2"><?php echo $lines[$i] . '</td></tr>'; ?><?php } else {

                                            ?><tr><td colspan="2"><?php
                                                    echo $lines[$i] . '</td></tr>';
                                                }
                                            }

                                            ?>

                        </tbody>

                    </table>
                    <!--</div>-->
                </div>
            <?php } else { ?>
                <div class="panel-body"><?php echo $lang['no_log'] ?></div>
            <?php } ?>
        </div>
    </div>
</div>