<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<div id="category" class="container">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><?php echo $lang['menu_categories'] ?></div>

                    <div class="add"><button type="submit" name="category_add" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addCategory"><span class="glyphicon glyphicon-plus"></span> <?php echo $lang['button_add'] ?></button>
                        <!-- Модальное окно "Добавить категорию" -->
<?php require_once('modal/categories_add.php') ?>
                    </div>
                    <div class="add"><select class="input-xs form-control"><option>10</option><option>30</option></select></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
<?php if ($lines == TRUE) { ?>
                <div class="panel-body">
                    <!--<div class="table-responsive">-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <div class="log-page"><?php echo $lang['s'] ?> <?php echo $i + 1 ?> <?php echo $lang['po'] ?> <?php echo $lines_p ?> ( <?php echo $lang['iz'] ?> <?php echo $counter; ?> )</div>
                                </th>
                                <th>
                                    <form>
                                        <input hidden name="i" value="<?php echo $i ?>">
                                        <input hidden name="lines_p" value="<?php echo $lines_p ?>">
                                        <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                        <div class="log-right"><button type="submit" class="btn btn-primary btn-xs" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-right"></span></button></div>
                                    </form>

                                    <form>
                                        <input hidden name="i2" value="<?php echo $i ?>">
                                        <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
                                        <input hidden name="parent_id_temp" value="<?php echo $parent_id ?>">
                                        <div class="log-left"><button type="submit" class="btn btn-primary btn-xs"  action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-chevron-left"></span></button></div>
                                    </form>

                                </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="2" align="left"><?php echo $lang['group_actions'] ?></th>
                                <th align="right">
                                    <div class="log-right"><input class="select-all check-box" type="checkbox" value=""></div>
                                    <form><input hidden name="log_delete" value="delete"><div class="log-left"><button type="submit" name="cat_delete_batch" class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo $lang['confirm-yes'] ?>" data-btn-cancel-label="<?php echo $lang['confirm-no'] ?>" title="<?php echo $lang['confirm-del'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div></form>
                                    <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_move'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-transfer"> </span></button></div>

                                </th>
                            </tr>
                        </tfoot>
                        <tbody id="sort-list">

                            <?php $parent_up = $lines[0][4]; ?>
    <?php if ($parent_up > 0) { ?>

                                <tr>
                                    <td colspan="3" align="left"><form><div><button name="parent_up" value="<?php echo $parent_up ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/categories/categories.php" formmethod="post">....</button></div></form></td>
                                </tr>

    <?php } for ($i; $i < $lines_p; $i++) { ?>

                                <tr class="sort-list" unitid="<?php echo $lines[$i][0] ?>">
                                    <?php if ($lines[$i][8] == 0) { ?>
                                        <td class="sortleft" align="left"><form><div><button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-default btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button></div></form></td>	  
                                    <?php } else { ?>
                                        <td class="sortleft" align="left"><form><div><button name="parent_down" value="<?php echo $lines[$i][0] ?>" class="btn btn-primary btn-xs" title="<?php echo $lines[$i][1] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-folder-open"> </span></button></div></form></td>
        <?php } ?>
                                    <td class="sortyes" align="left"><div><?php echo $lines[$i][1] ?></div></td>	  
                                    <td class="sorthidden" align="right">
                                        <div class="log-right"><input class="select-item check-box" type="checkbox" value=""></div>
                                        <form><div class="log-left"><button class="btn btn-primary btn-xs" data-toggle="confirmation" data-btn-ok-label="<?php echo $lang['confirm-yes'] ?>" data-btn-cancel-label="<?php echo $lang['confirm-no'] ?>" title="<?php echo $lang['confirm-del'] ?>" name="cat_delete" value="<?php echo $lines[$i][0] ?>" action="/controller/admin/pages/categories/categories.php" formmethod="post"><span class="glyphicon glyphicon-trash"> </span></button></div></form>
                                        <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_move'] ?>" action="" formmethod="post"><span class="glyphicon glyphicon-transfer"> </span></button></div>
                                        <div class="log-left"><button class="btn btn-primary btn-xs" title="<?php echo $lang['button_edit'] ?>" name="but_edit" data-toggle="modal" data-target="<?php echo '#addCategory' . $lines[$i][0] ?>"><span class="glyphicon glyphicon-list-alt"> </span></button>
                                            <!-- Модальное окно "Редактировать категорию" -->
        <?php require('modal/categories_edit.php') ?>
                                            <!-- КОНЕЦ Модальное окно "Редактировать категорию" -->
                                        </div>
                                    </td>
                                </tr>

    <?php } ?>

                        </tbody>

                    </table>
                    <!--</div>-->
                </div>

<?php } elseif ($lines == FALSE && $VALID->inPOST('parent_down') > 0) { ?>

                <div class="panel-body"><p><?php echo $lang['no_cat'] ?></p>
                    <!--<div class="table-responsive">-->
                    <table class="table">
                        <tbody>
                            <tr>
                                <td align="left"><form><div><button name="parent_up" value="<?php echo $VALID->inPOST('parent_down') ?>" class="btn btn-default btn-xs" title="" action="/controller/admin/pages/categories/categories.php" formmethod="post">....</button></div></form></td>
                            </tr>
                        </tbody>
                    </table>
                    <!--</div>-->
                </div>
            <?php } else { ?>
                <div class="panel-body"><?php echo $lang['no_cat'] ?></div>
<?php } ?>
        </div>
    </div>
</div>