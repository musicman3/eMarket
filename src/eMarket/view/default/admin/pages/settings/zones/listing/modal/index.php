<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Func,
    Settings
};
use eMarket\Admin\ZonesListing;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">

                <div class="modal-footer">
                    <input hidden name="route" value="settings/zones/listing">
                    <input type="hidden" name="add" value="ok" />
                    <input hidden name="zone_id" value="<?php echo ZonesListing::$zones_id ?>">

                    <span class="multiselect-native-select me-auto">
                        <select id="multiselect" name="multiselect[]" multiple="multiple">
                            <?php
                            foreach (ZonesListing::$countries_multiselect as $k => $v) {
                                if (in_array([$k], ZonesListing::$lines) == TRUE && count(ZonesListing::$regions) != 0) {
                                    ?>

                                    <optgroup class="multiselect-add" label="<?php echo $v ?>">
                                    <?php } else {
                                        ?>

                                    <optgroup label="<?php echo $v ?>">
                                        <?php
                                    }
                                    foreach (Func::filterArrayToKeyAssoc(ZonesListing::$regions_multiselect, 'country_id', $k, 'name', 'id') as $k2 => $v2) {

                                        if (in_array([$k], ZonesListing::$lines) == TRUE && isset(ZonesListing::$regions[ZonesListing::$count]['regions_id']) == TRUE && $k2 == ZonesListing::$regions[ZonesListing::$count]['regions_id']) {
                                            ZonesListing::$count++;
                                            ?>

                                            <option value="<?php echo $k ?>-<?php echo $k2 ?>" selected="selected"><?php echo $v2 ?></option>
                                            <?php
                                        } else {
                                            ?>

                                            <option value="<?php echo $k ?>-<?php echo $k2 ?>"><?php echo $v2 ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </span>

                    <button class="btn btn-primary btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                    <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>