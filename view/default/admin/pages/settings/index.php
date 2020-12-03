<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

    <div id="settings" class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo lang('title_settings_index') ?>
                </h3>
            </div>
            <div class="panel-body">
		<div class="table-responsive">
		    <table class="table">
			<tbody>
			    <tr>
				<td>
				    <div class="settings"><a href="?route=settings/countries" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-globe glyph-xs"> </span></a><?php echo lang('title_settings_countries_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/zones" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-adjust glyph-xs"> </span></a><?php echo lang('title_settings_zones_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/taxes" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-briefcase glyph-xs"> </span></a><?php echo lang('title_settings_taxes_index') ?></div>
				</td>
			    </tr>
			    <tr>
				<td>
				    <div class="settings"><a href="?route=settings/length" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-road glyph-xs"> </span></a><?php echo lang('title_settings_length_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/weight" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-scale glyph-xs"> </span></a><?php echo lang('title_settings_weight_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/templates" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-th-large glyph-xs"> </span></a><?php echo lang('title_settings_templates_index') ?></div>
				</td>
			    </tr>
			    <tr>
				<td>
				    <div class="settings"><a href="?route=settings/vendor_codes" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-tag glyph-xs"> </span></a><?php echo lang('title_settings_vendor_codes_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/units" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-flag glyph-xs"> </span></a><?php echo lang('title_settings_units_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/modules" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-equalizer glyph-xs"> </span></a><?php echo lang('title_settings_modules_index') ?></div>
				</td>
			    </tr>
			    <tr>
				<td>
				    <div class="settings"><a href="?route=settings/basic_settings" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-cog glyph-xs"> </span></a><?php echo lang('title_settings_basic_settings_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/currencies" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-euro glyph-xs"> </span></a><?php echo lang('title_settings_currencies_index') ?></div>
				</td>
				<td>
				    <div class="settings"><a href="?route=settings/order_status" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pushpin glyph-xs"> </span></a><?php echo lang('title_settings_order_status_index') ?></div>
				</td>
			    </tr>
			</tbody>
		    </table>
                </div>
            </div>
        </div>
    </div>