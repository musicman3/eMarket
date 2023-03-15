<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Messages,
    Routing
};
use eMarket\Catalog\{
    WithoutRegistration
};

foreach (Routing::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/privacy_policy.php')
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('without_registration_index') ?></h1>

<div id="ajax_data" class='hidden'
     data-json='<?php echo WithoutRegistration::$address_data_json ?>'
     data-countries='<?php echo WithoutRegistration::$countries_data_json ?>'
     data-registrationdata='<?php echo WithoutRegistration::$without_registration_data ?>'
     data-registrationuser='<?php echo WithoutRegistration::$without_registration_user ?>'
     ></div>
<input type="hidden" id="add" name="add" value="" />

<div id="register" class="contentText">
    <form class="was-validated" enctype="multipart/form-data" method="post" action="">
        <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
        <div class="row">
            <div class="col-md-6">
                <fieldset id="account">
                    <legend><?php echo lang('register_personal_details') ?></legend>
                    <small class="form-text text-muted"><?php echo lang('register_first_name') ?></small>
                    <div class="input-group firstname">
                        <span class="input-group-text bi-person"></span>
                        <input class="form-control" type="text" placeholder="<?php echo lang('register_first_name') ?>" minlength="1" id="input-firstname" value="" name="firstname" required>
                    </div>
                    <small class="form-text text-muted"><?php echo lang('register_last_name') ?></small>
                    <div class="input-group lastname">
                        <span class="input-group-text bi-person"></span>
                        <input class="form-control" type="text" placeholder="<?php echo lang('register_last_name') ?>" minlength="1" id="input-lastname" value="" name="lastname" required>
                    </div>
                    <small class="form-text text-muted"><?php echo lang('register_telephone') ?></small>
                    <div class="input-group telephone">
                        <span class="input-group-text bi-telephone"></span>
                        <input class="form-control" placeholder="<?php echo lang('register_telephone') ?>" type="tel" pattern="(\+[0-9]{10,13})" id="input-telephone" value="" name="telephone" required>
                    </div>
                    <br>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend><?php echo lang('without_registration_your_address') ?></legend>
                    <small class="form-text text-muted"><?php echo lang('address_book_country') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <select name="countries" id="countries" class="form-select">
                            <option value=""></option>
                        </select>
                    </div>
                    <small class="form-text text-muted"><?php echo lang('address_book_region') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <select name="regions" id="regions" class="form-select">
                            <option value=""></option>
                        </select>
                    </div>
                    <small class="form-text text-muted"><?php echo lang('address_book_city') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('address_book_city_placeholder') ?>" type="text" name="city"  id="city" required />
                    </div>
                    <small class="form-text text-muted"><?php echo lang('address_book_zip') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('address_book_zip_placeholder') ?>" type="text" name="zip"  id="zip" required />
                    </div>
                    <small class="form-text text-muted"><?php echo lang('address_book_shipping_address') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('address_book_address_placeholder') ?>" type="text" name="address"  id="address" required />
                    </div>
                    <br>
                </fieldset>
            </div>
        </div>

        <div class="text-end mb-3 form-switch">
            <?php echo sprintf(lang('register_privacy_statement_agree'), '#privacy_policy') ?>&nbsp;
            <input class="form-check-input" type="checkbox" name="agree_privacy_policy" id="agree_privacy_policy" required>&nbsp;
            <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
        </div>
    </form>
</div>
