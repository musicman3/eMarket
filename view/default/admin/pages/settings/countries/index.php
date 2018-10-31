<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>
<!-- Модальное окно "Добавить" -->
<?php require_once('modal/add.php') ?>
<!-- КОНЕЦ Модальное окно "Добавить" -->

<!-- Дублируем модальные окна Редактирования -->
<?php $k = $l_start; // дублируем переменную   ?>

<?php for ($k; $k < $l_finish; $k++) { // запускаем цикл формирования модальных окон  ?>

    <!-- Вставляем модальное окно "Редактировать" -->
    <?php require(ROOT . '/view/'.$TEMPLATE.'/admin/pages/settings/countries/modal/edit.php') ?>

<?php } ?>

<div id="ajax">
    <div id="settings" class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="pull-left"><?php echo $lang['title_countries'] ?></div>
                        <div class="clearfix"></div>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <?php if ($lines == TRUE) { ?>
                                        <div class="page"><?php echo $lang['s'] ?> <?php echo $l_start + 1 ?> <?php echo $lang['po'] ?> <?php echo $l_finish ?> ( <?php echo $lang['iz'] ?> <?php echo count($lines) ?> )</div>
                                        <?php
                                    } else {

                                        ?>
                                        <div><?php echo $lang['no_countries'] ?></div>
                                    <?php } ?>
                                </th>

                                <th>
                                    <form>
                                        <?php if (count($lines) > $l_page) { ?>
                                            <input hidden name="l_start" value="<?php echo $l_start ?>">
                                            <input hidden name="l_finish" value="<?php echo $l_finish ?>">
                                        <?php } ?>
                                        <div class="right"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>


                                    <form>
                                        <?php if (count($lines) > $l_page) { ?>
                                            <input hidden name="l_start2" value="<?php echo $l_start ?>">
                                            <input hidden name="l_finish2" value="<?php echo $l_finish ?>">
                                        <?php } ?>
                                        <div class="left"><button type="submit" class="btn btn-primary btn-xs" action="index.php" formmethod="get"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </form>

                                    <div class="left">
                                        <a href="#add" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span></a>
                                    </div>
                                </th>
                            </tr>
			    <?php if ($lines == TRUE) { ?>
                            <tr class="border">
                                <th class="sortleft"></th>
                                <th><?php echo $lang['country'] ?></th>
                                <th class="al-text"><?php echo $lang['alpha_2'] ?></th>
                                <th class="al-text"><?php echo $lang['alpha_3'] ?></th>
                                <th class="al-text"><?php echo $lang['country_flag'] ?></th>
                                <th class="al-text-w"></th>
                            </tr>
			    <?php } ?>
                        </thead>
                        <tbody>
                            <?php for ($l_start; $l_start < $l_finish; $l_start++) { ?>
                                <tr>
                                    <td class="sortleft">
                                        <form action="regions/index.php">
                                            <input hidden name="country_id" value="<?php echo $lines[$l_start][0] ?>">
                                            <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog"></span></button>
                                        </form>
                                    </td>
                                    <td><?php echo $lines[$l_start][1] ?></td>
                                    <td class="al-text"><?php echo $lines[$l_start][2] ?></td>
                                    <td class="al-text"><?php echo $lines[$l_start][3] ?></td>
                                    <td class="al-text"><img src='/view/<?php echo $TEMPLATE ?>/admin/images/worldflags/<?php echo strtolower($lines[$l_start][2]) ?>.png'></td>
                                    <td class="al-text-w">
                                        <form>
                                            <input hidden name="delete" value="<?php echo $lines[$l_start][0] ?>">
                                            <div class="right">
                                                <button type="submit" name="delete_but" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo $lang['confirm-yes'] ?>" data-btn-cancel-label="<?php echo $lang['confirm-no'] ?>" title="<?php echo $lang['confirm-del'] ?>" action="index.php" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button>
                                            </div>
                                            <div class="left">
                                                <a href="#edit<?php echo $lines[$l_start][0] ?>" class="btn btn-primary btn-xs" data-toggle="modal"><span class="glyphicon glyphicon-edit"></span></a>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
