<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Settings
};
?>

<div id="settings">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title col text-center"><?php echo Settings::titlePageGenerator() ?></h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-primary text-center"><span class="bi-circle-fill"></span></div>
                        <div class="card-body">
                            <div class="mb-2"><a href="?route=settings/basic_settings" class="btn btn-primary btn-sm bi-gear-fill"></a> <?php echo lang('title_settings_basic_settings_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/currencies" class="btn btn-primary btn-sm bi-cash"></a> <?php echo lang('title_settings_currencies_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/order_status" class="btn btn-primary btn-sm bi-pin-angle-fill"></a> <?php echo lang('title_settings_order_status_index') ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-primary text-center"><span class="bi-circle-fill"></span></div>
                        <div class="card-body">
                            <div class="mb-2"><a href="?route=settings/length" class="btn btn-primary btn-sm bi-rulers"></a> <?php echo lang('title_settings_length_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/weight" class="btn btn-primary btn-sm bi-minecart-loaded"></a> <?php echo lang('title_settings_weight_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/vendor_codes" class="btn btn-primary btn-sm bi-tag-fill"></a> <?php echo lang('title_settings_vendor_codes_index') ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-primary text-center"><span class="bi-circle-fill"></span></div>
                        <div class="card-body">
                            <div class="mb-2"><a href="?route=settings/units" class="btn btn-primary btn-sm bi-flag-fill"></a> <?php echo lang('title_settings_units_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/templates" class="btn btn-primary btn-sm bi-intersect"></a> <?php echo lang('title_settings_templates_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/modules" class="btn btn-primary btn-sm bi-cpu-fill"></a> <?php echo lang('title_settings_modules_index') ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-primary text-center"><span class="bi-circle-fill"></span></div>
                        <div class="card-body">
                            <div class="mb-2"><a href="?route=settings/countries" class="btn btn-primary btn-sm bi-globe"></a> <?php echo lang('title_settings_countries_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/zones" class="btn btn-primary btn-sm bi-geo-alt-fill"></a> <?php echo lang('title_settings_zones_index') ?></div>
                            <div class="mb-2"><a href="?route=settings/taxes" class="btn btn-primary btn-sm bi-percent"></a> <?php echo lang('title_settings_taxes_index') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>