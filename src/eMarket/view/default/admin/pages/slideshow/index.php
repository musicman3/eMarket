<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Clock\SystemClock,
    Lang,
    Messages,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\Slideshow;

require_once('modal/settings.php');
require_once('modal/index.php')
?>

<div id="slideshow">
    <div class="card">
        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>
        <div class="card-body">
            <div id="ajax_data" class='hidden' 
                 data-jsonsettings='<?php echo Slideshow::$settings ?>'
                 data-jsondata='<?php echo Slideshow::$json_data ?>'></div>

            <div class="float-end slide-sett"><button class="btn btn-primary btn-sm bi-gear-fill" type="button" data-bs-toggle="modal" data-bs-target="#settings"></button></div>
            <ul class="nav nav-tabs">

                <?php for ($x = 0; $x < Lang::$count; $x++) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo Pages::activeTab(Slideshow::$set_language, lang('#lang_all')[$x]) ?>" data-bs-toggle="tab" href="#<?php echo lang('#lang_all')[$x] ?>"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$x] ?>.png" alt="<?php echo lang('#lang_all')[$x] ?>" title="<?php echo lang('#lang_all')[$x] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[$x]) ?></a>
                    </li>
                <?php } ?>

            </ul>

            <div class="ajax-tab tab-content pt-2">

                <?php for ($x = 0; $x < Lang::$count; $x++, Slideshow::helper()) { ?>

                    <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade <?php echo Pages::activeTab($x) ?>">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="align-middle">
                                        <th colspan="5"><?php echo Pages::counterPage() ?></th>

                                        <th>
                                            <div class="gap-2 d-flex justify-content-end">

                                                <a href="#index" class="btn btn-primary btn-sm bi-plus" data-bs-toggle="modal"></a>

                                                <form>
                                                    <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                    <input hidden name="slide_lang" value="<?php echo Valid::inGET('slide_lang') ?>">
                                                    <input hidden name="backstart" value="<?php echo Pages::$start ?>">
                                                    <input hidden name="backfinish" value="<?php echo Pages::$finish ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm bi-arrow-left-short <?php echo Pages::leftButton() ?>"></button>
                                                </form>

                                                <form>
                                                    <input hidden name="route" value="<?php echo Valid::inGET('route') ?>">
                                                    <input hidden name="slide_lang" value="<?php echo Valid::inGET('slide_lang') ?>">
                                                    <input hidden name="start" value="<?php echo Pages::$start ?>">
                                                    <input hidden name="finish" value="<?php echo Pages::$finish ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm bi-arrow-right-short <?php echo Pages::rightButton() ?>"></button>
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
                                    <?php } ?>
                                </thead>
                                <tbody>
                                    <?php for (Pages::$start; Pages::$start < Pages::$finish; Pages::$start++, Pages::lineUpdate()) { ?>
                                        <tr class="<?php echo Pages::statusSwitchClass(Pages::$table['line']['status'], [Slideshow::$this_time, SystemClock::getUnixTime(Pages::$table['line']['date_start'])], [SystemClock::getUnixTime(Pages::$table['line']['date_finish']), Slideshow::$this_time]) ?> align-middle">
                                            <td><img src="/uploads/images/slideshow/resize_0/<?php echo Pages::$table['line']['logo_general'] ?>" onError="this.style.display='none'" /></td>
                                            <td class="text-center"><?php echo count(json_decode(Pages::$table['line']['logo'])) ?></td>
                                            <td class="text-center"><?php echo Pages::$table['line']['name'] ?></td>
                                            <td class="text-center"><?php echo SystemClock::getDate(Pages::$table['line']['date_start']); ?></td>
                                            <td class="text-center"><?php echo SystemClock::getDate(Pages::$table['line']['date_finish']); ?></td>
                                            <td>
                                                <div class="gap-2 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary btn-sm bi-pencil-square" data-bs-toggle="modal" data-bs-target="#index" data-edit="<?php echo Pages::$table['line']['id'] ?>"></button>
                                                    <form id="form_delete<?php echo Pages::$table['line']['id'] ?>" name="form_delete" action="javascript:void(null);" enctype="multipart/form-data">
                                                        <input hidden name="delete" value="<?php echo Pages::$table['line']['id'] ?>">
                                                        <button type="button" name="delete_but" class="btn btn-primary btn-sm bi-trash" onclick="Confirmation.del('<?php echo Pages::$table['line']['id'] ?>')"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>