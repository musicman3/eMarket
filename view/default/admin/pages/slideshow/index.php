<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Lang,
    Messages,
    Pages,
    Settings,
    Valid
};
use \eMarket\Admin\Slideshow;

require_once('modal/settings.php');
require_once('modal/index.php')
?>

<div id="slideshow">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="card-title">
                <?php echo Settings::titlePageGenerator() ?>
            </h3>
        </div>
        <div class="modal-body">
            <div id="ajax_data" class='hidden' 
                 data-jsonsettings='<?php echo Slideshow::$settings ?>'
                 data-jsondata='<?php echo Slideshow::$json_data ?>'></div>

            <div class="float-end slide-sett"><a href="#settings" class="btn btn-primary btn-sm" data-bs-toggle="modal"><span class="bi-gear-fill"></span></a></div>

            <ul class="nav nav-tabs">
                <li class="<?php echo Settings::activeTab(Slideshow::$set_language, lang('#lang_all')[0]) ?>"><a data-bs-toggle="tab" href="#<?php echo lang('#lang_all')[0] ?>"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[0]) ?></a></li>

                <?php
                if (Lang::$count > 1) {
                    for ($x = 1; $x < Lang::$count; $x++) {
                        ?>

                        <li class="<?php echo Settings::activeTab(Slideshow::$set_language, lang('#lang_all')[$x]) ?>"><a data-bs-toggle="tab" href="#<?php echo lang('#lang_all')[$x] ?>"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$x] ?>.png" alt="<?php echo lang('#lang_all')[$x] ?>" title="<?php echo lang('#lang_all')[$x] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[$x]) ?></a></li>

                        <?php
                    }
                }
                ?>

            </ul>

            <div class="ajax-tab tab-content">
                <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="align-middle">
                                    <th colspan="5"><?php echo Pages::counterPage() ?></th>

                                    <th>
                                        <div class="gap-2 d-flex justify-content-end">

                                            <a href="#index" class="btn btn-primary btn-sm" data-bs-toggle="modal"><span class="bi-plus"></span></a>
 
                                            <form>
                                                <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                <input hidden name="slide_lang" value="<?php echo Valid::inGET('slide_lang') ?>">
                                                <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                                <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                                <?php if (Pages::$start > 0) { ?>
                                                    <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-left-short"></span></button>
                                                <?php } else { ?>
                                                    <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-left-short"></span></a>
                                                <?php } ?>
                                            </form>

                                            <form>
                                                <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                <input hidden name="slide_lang" value="<?php echo Valid::inGET('slide_lang') ?>">
                                                <input hidden name="start" value="<?php echo Pages::$start ?>">
                                                <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                                <?php if (Pages::$finish != Pages::$count) { ?>
                                                    <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-right-short"></span></button>
                                                <?php } else { ?>
                                                    <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-right-short"></span></a>
                                                <?php } ?>
                                            </form>

                                        </div>
                                    </th>
                                </tr>
                                <?php if (Pages::$count > 0) { ?>
                                    <tr class="align-middle">
                                        <th><?php echo lang('slides_image') ?></th>
                                        <th class="text-center"><?php echo lang('slides_quantity') ?></th>
                                        <th class="text-center"><?php echo lang('slides_name') ?></th>
                                        <th class="text-center"><?php echo lang('slides_show_start') ?></th>
                                        <th class="text-center"><?php echo lang('slides_show_end') ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            <?php } ?>
                            <tbody>
                                <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                                    <tr class="<?php echo Settings::statusSwitchClass(Pages::$table['line']['status'], [Slideshow::$this_time, strtotime(Pages::$table['line']['date_start'])], [strtotime(Pages::$table['line']['date_finish']), Slideshow::$this_time]) ?> align-middle">
                                        <td><img src="/uploads/images/slideshow/resize_0/<?php echo Pages::$table['line']['logo_general'] ?>" /></td>
                                        <td class="text-center"><?php echo count(json_decode(Pages::$table['line']['logo'])) ?></td>
                                        <td class="text-center"><?php echo Pages::$table['line']['name'] ?></td>
                                        <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_start']); ?></td>
                                        <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_finish']); ?></td>
                                        <td>
                                            <div class="gap-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"><span class="bi-pencil-square"></span></button>
                                                <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                                    <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                                    <button type="submit" name="delete_but" class="btn btn-primary btn-sm" data-bs-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="bi-trash"> </span></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                if (Lang::$count > 1) {
                    for ($x = 1; $x < Lang::$count; $x++, Slideshow::helper()) {
                        ?>

                        <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                            <div class="table-responsive">
                                <table class="table table-hover">

                                    <thead>
                                        <tr class="align-middle">
                                            <th colspan="4"><?php echo Pages::counterPage() ?></th>

                                            <th>
                                                <div class="gap-2 d-flex justify-content-end">

                                                    <a href="#index" class="btn btn-primary btn-sm" data-bs-toggle="modal"><span class="bi-plus"></span></a>

                                                    <form>
                                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                        <input hidden name="slide_lang" value="<?php echo Valid::inGET('slide_lang') ?>">
                                                        <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                                        <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                                        <?php if (Pages::$start > 0) { ?>
                                                            <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-left-short"></span></button>
                                                        <?php } else { ?>
                                                            <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-left-short"></span></a>
                                                        <?php } ?>
                                                    </form>

                                                    <form>
                                                        <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                        <input hidden name="slide_lang" value="<?php echo Valid::inGET('slide_lang') ?>">
                                                        <input hidden name="start" value="<?php echo Pages::$start ?>">
                                                        <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                                        <?php if (Pages::$finish != Pages::$count) { ?>
                                                            <button type="submit" class="btn btn-primary btn-sm" formmethod="get"><span class="bi-arrow-right-short"></span></button>
                                                        <?php } else { ?>
                                                            <a type="submit" class="btn btn-primary btn-sm disabled"><span class="bi-arrow-right-short"></span></a>
                                                        <?php } ?>
                                                    </form>

                                                </div>
                                            </th>
                                        </tr>

                                        <tr class="align-middle">
                                            <th><?php echo lang('slides_image') ?></th>
                                            <th class="text-center"><?php echo lang('slides_quantity') ?></th>
                                            <th class="text-center"><?php echo lang('slides_name') ?></th>
                                            <th class="text-center"><?php echo lang('slides_show_start') ?></th>
                                            <th class="text-center"><?php echo lang('slides_show_end') ?></th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                                            <tr class="<?php echo Settings::statusSwitchClass(Pages::$table['line']['status'], [Slideshow::$this_time, strtotime(Pages::$table['line']['date_start'])], [strtotime(Pages::$table['line']['date_finish']), Slideshow::$this_time]) ?> align-middle">
                                                <td><img src="/uploads/images/slideshow/resize_0/<?php echo Pages::$table['line']['logo_general'] ?>" /></td>
                                                <td class="text-center"><?php echo count(json_decode(Pages::$table['line']['logo'])) ?></td>
                                                <td class="text-center"><?php echo Pages::$table['line']['name'] ?></td>
                                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_start']); ?></td>
                                                <td class="text-center"><?php echo Settings::dateLocale(Pages::$table['line']['date_finish']); ?></td>
                                                <td>
                                                    <div class="gap-2 d-flex justify-content-end">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"><span class="bi-pencil-square"></span></button>
                                                        <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" onsubmit="Ajax.callDelete('<?php echo Pages::$table['line']['id'] ?>')" enctype="multipart/form-data">
                                                            <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                                            <button type="submit" name="delete_but" class="btn btn-primary btn-sm" data-bs-placement="left" data-bs-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-label="<?php echo lang('confirm-yes') ?>" data-btn-cancel-label="<?php echo lang('confirm-no') ?>" title="<?php echo lang('confirm-del') ?>"><span class="bi-trash"> </span></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>