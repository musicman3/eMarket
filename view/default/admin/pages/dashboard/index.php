<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages
};
use \eMarket\Admin\{
    Dashboard
};
?>

<div id="dashboard">

    <div id="alert_block"><?php Messages::alert(); ?></div>
    <div id="ajax_data" class='hidden' 
         data-jsondata='<?php echo Dashboard::$json_data ?>'>
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-0 text-center">
        <div class="col g-1">
            <div class="card h-100">
                <div class="card-header text-white bg-success"><?php echo lang('dashboard_new_customers') ?></div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo count(Dashboard::customersData()) ?></h4>
                </div>
            </div>
        </div>

        <div class="col g-1">
            <div class="card h-100">
                <div class="card-header text-white bg-success"><?php echo lang('dashboard_average_check') ?></div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo Dashboard::$average_check ?></h4>
                </div>
            </div>
        </div>

        <div class="col g-1">
            <div class="card h-100">
                <div class="card-header text-white bg-success"><?php echo lang('dashboard_repeat_orders') ?></div>
                <div id="new_old_orders"></div>
            </div>
        </div>
        <div class="col g-1">
            <div class="card h-100 border-danger">
                <div class="card-header text-white bg-danger"><?php echo lang('dashboard_period') ?></div>
                <div class="card-body">
                    <select id="years" class="form-select text-center border-danger">
                        <?php for ($x = date('Y'); $x > Dashboard::minYear() - 1; $x--) { ?>
                            <option value="<?php echo $x ?>"<?php echo Dashboard::selectedYear($x) ?>><?php echo $x ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-0 text-center">
        <div class="col g-1">
            <div class="card h-100">
                <div class="card-header text-white bg-success"><?php echo lang('dashboard_orders_by_day_of_the_week') ?></div>
                <div class="card-body">
                    <div id="week_days" class="card h-100"></div>
                </div>
            </div>
        </div>

        <div class="col g-1">
            <div class="card h-100">
                <div class="card-header text-white bg-success"><?php echo lang('dashboard_orders_quantity') ?></div>
                <div class="card-body">
                    <div id="orders_quantity" class="card h-100"></div>
                </div>
            </div>
        </div>

        <div class="col g-1">
            <div class="card h-100">
                <div class="card-header text-white bg-success"><?php echo lang('dashboard_proceeds') ?></div>
                <div class="card-body">
                    <div id="proceeds" class="card h-100"></div>
                </div>
            </div>
        </div>
    </div>

</div>
