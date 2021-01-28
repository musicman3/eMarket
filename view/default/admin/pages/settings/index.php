<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="settings">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <?php echo lang('title_settings_index') ?>
            </h5>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <div class="float-start"><a href="?route=settings/basic_settings" class="btn btn-primary btn-sm"><span class="bi-gear-fill"> </span></a> <?php echo lang('title_settings_basic_settings_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/currencies" class="btn btn-primary btn-sm"><span class="bi-cash"> </span></a> <?php echo lang('title_settings_currencies_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/taxes" class="btn btn-primary btn-sm"><span class="bi-percent"> </span></a> <?php echo lang('title_settings_taxes_index') ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="float-start"><a href="?route=settings/length" class="btn btn-primary btn-sm"><span class="bi-rulers"> </span></a> <?php echo lang('title_settings_length_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/weight" class="btn btn-primary btn-sm"><span class="bi-minecart-loaded"> </span></a> <?php echo lang('title_settings_weight_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/templates" class="btn btn-primary btn-sm"><span class="bi-intersect"> </span></a> <?php echo lang('title_settings_templates_index') ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="float-start"><a href="?route=settings/vendor_codes" class="btn btn-primary btn-sm"><span class="bi-tag-fill"> </span></a> <?php echo lang('title_settings_vendor_codes_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/units" class="btn btn-primary btn-sm"><span class="bi-flag-fill"> </span></a> <?php echo lang('title_settings_units_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/modules" class="btn btn-primary btn-sm"><span class="bi-cpu-fill"> </span></a> <?php echo lang('title_settings_modules_index') ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="float-start"><a href="?route=settings/countries" class="btn btn-primary btn-sm"><span class="bi-globe"> </span></a> <?php echo lang('title_settings_countries_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/zones" class="btn btn-primary btn-sm"><span class="bi-geo-alt-fill"> </span></a> <?php echo lang('title_settings_zones_index') ?></div>
                            </td>
                            <td>
                                <div class="float-start"><a href="?route=settings/order_status" class="btn btn-primary btn-sm"><span class="bi-pin-angle-fill"> </span></a> <?php echo lang('title_settings_order_status_index') ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>