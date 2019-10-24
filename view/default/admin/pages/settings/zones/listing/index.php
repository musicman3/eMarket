<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Модальное окно "Добавить" -->
<?php require_once('modal/add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<div id="ajax">
    <div id="settings_zones_listing" class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!--Выводим уведомление об успешном действии-->
                    <?php \eMarket\Messages::alert(); ?>
                    <h3 class="panel-title">
                        <div class="pull-left"><span class="settings_back"><a class="btn btn-primary btn-xs" href="<?php echo $_SESSION['zone_page'] ?>"><span class="back glyphicon glyphicon-share-alt"></span></a></span><span class="settings_name"><?php echo \eMarket\Set::titlePageGenerator() ?></span></div>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <?php if ($lines == TRUE) { ?>
                                        <div class="page"><?php echo lang('s') ?> <?php echo $start + 1 ?> <?php echo lang('po') ?> <?php echo $finish ?> ( <?php echo lang('iz') ?> <?php echo count($lines); ?> )</div>
                                        <?php
                                    } else {

                                        ?>
                                        <div><?php echo lang('no_listing') ?></div>
                                    <?php } ?>
                                </th>

                                <th>
                                
                                    <div class="right"><a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a></div>
                                
                                    <form>
                                        <?php if (count($lines) > $lines_on_page) { ?>
                                            <input hidden name="route" value="settings/zones/listing">
                                            <input hidden name="start" value="<?php echo $start ?>">
                                            <input hidden name="finish" value="<?php echo $finish ?>">
                                            <input hidden name="zone_id" value="<?php echo $zones_id ?>">
                                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                        <?php } ?>
                                    </form>

                                    <form>
                                        <?php if (count($lines) > $lines_on_page) { ?>
                                            <input hidden name="route" value="settings/zones/listing">
                                            <input hidden name="start2" value="<?php echo $start ?>">
                                            <input hidden name="finish2" value="<?php echo $finish ?>">
                                            <input hidden name="zone_id" value="<?php echo $zones_id ?>">
                                            <div class="left"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                        <?php } ?>
                                    </form>

                                </th>
                            </tr>
                            <?php if ($lines == TRUE) { ?>
                                <tr class="border">
                                    <th> </th>
                                    <th><?php echo lang('country') ?></th>
                                    <th> </th>
                                </tr>
                            <?php } ?>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            for ($start; $start < $finish; $start++) {

                                ?>
                                <tr>
                                    <td class="sortleft"><a class="btn btn-primary btn-xs" href="#" ><span data-toggle="tooltip" data-html="true" data-placement="right" data-original-title="<?php echo $text_arr[$count] ?>" class="glyphicon glyphicon-eye-open"></span></a></td>
                                    <td><?php echo \eMarket\Func::filterArrayToKey($name_country, 0, $lines[$start][0], 1)[0] ?></td>
                                    <td> </td>
                                </tr>
                                <?php
                                $count++;
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
