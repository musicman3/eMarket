<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    Settings,
    Pages
};
use eMarket\Admin\BasicSettings;
?>

<div id="settings_basic_settings">
    <div class="card">

        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#general"><?php echo lang('basic_settigs_general') ?></a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#email"><?php echo lang('basic_settigs_email') ?></a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cache"><?php echo lang('basic_settings_caching') ?></a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#logo"><?php echo lang('basic_settings_logo') ?></a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#update"><?php echo lang('basic_settings_update') ?></a></li>
            </ul>

            <div class="tab-content pt-2">
                <div id="general" class="tab-pane fade show in active">
                    <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                        <input hidden name="add" value="ok">

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_store_name') ?></label>
                            <div class="col-md-9">
                                <input type="text" name="store_name" class="input-sm form-control" value="<?php echo htmlspecialchars(BasicSettings::$store_name) ?>" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_year_of_foundation') ?></label>
                            <div class="col-md-9">
                                <input type="text" name="year_of_foundation" class="input-sm form-control" value="<?php echo BasicSettings::$year_of_foundation ?>" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_primary_language') ?></label>
                            <div class="col-md-9">
                                <select name="primary_language" id="primary_language" class="input-sm form-select">
                                    <?php foreach (lang('#lang_all') as $langs) { ?>
                                        <option value="<?php echo $langs ?>"><?php echo lang('language_name', $langs) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_default_template') ?></label>
                            <div class="col-md-9">
                                <select name="default_template" id="default_template" class="input-sm form-select">
                                    <?php foreach (BasicSettings::$templates as $name) { ?>
                                        <option value="<?php echo $name ?>" <?php echo Pages::selectedAttr($name, BasicSettings::$template) ?>><?php echo $name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('lines_on_page') ?></label>
                            <div class="col-md-9">
                                <input type="text" name="lines_on_page" class="input-sm form-control" value="<?php echo Settings::linesOnPage() ?>" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('session_expr_time') ?> <span data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo lang('session_expr_time_help') ?>" class="bi-question-circle"></span></label>
                            <div class="col-md-9">
                                <input type="text" name="session_expr_time" class="input-sm form-control" value="<?php echo Settings::adminSessionTime() ?>" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('debug_info') ?></label>
                            <div class="col-md-9">
                                <select name="debug" id="debug" class="input-sm form-select">
                                    <option value="off"><?php echo lang('debug_off') ?></option>
                                    <option value="on" <?php echo Pages::selectedAttr(BasicSettings::$debug) ?>><?php echo lang('debug_on') ?></option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                    </form>
                </div>
                <div id="email" class="tab-pane fade">
                    <form id="form_email" class="was-validated" name="form_email" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_email')">
                        <input hidden name="add" value="ok">

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_email') ?></label>
                            <div class="col-md-9">
                                <input type="email" name="email" class="input-sm form-control" value="<?php echo BasicSettings::$email ?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_email_name') ?></label>
                            <div class="col-md-9">
                                <input type="text" name="email_name" class="input-sm form-control" value="<?php echo BasicSettings::$email_name ?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_smtp_use') ?></label>
                            <div class="col-md-9">
                                <select name="smtp_status" id="smtp_status" class="input-sm form-select">
                                    <option value="off"><?php echo lang('debug_off') ?></option>
                                    <option value="on" <?php echo Pages::selectedAttr(BasicSettings::$smtp_status) ?>><?php echo lang('debug_on') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_smtp_auth') ?></label>
                            <div class="col-md-9">
                                <select name="smtp_auth" id="smtp_auth" class="input-sm form-select">
                                    <option value="off"><?php echo lang('debug_off') ?></option>
                                    <option value="on" <?php echo Pages::selectedAttr(BasicSettings::$smtp_auth) ?>><?php echo lang('debug_on') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_host_email') ?></label>
                            <div class="col-md-9">
                                <input type="text" id="host_email" name="host_email" class="input-sm form-control" value="<?php echo BasicSettings::$host_email ?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_username_email') ?></label>
                            <div class="col-md-9">
                                <input type="text" id="username_email" name="username_email" class="input-sm form-control" value="<?php echo BasicSettings::$username_email ?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_password_email') ?></label>
                            <div class="col-md-9">
                                <input type="password" id="password_email" name="password_email" class="input-sm form-control" value="<?php echo BasicSettings::$password_email ?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_smtp_secure') ?></label>
                            <div class="col-md-9">
                                <input type="text" id="smtp_secure" name="smtp_secure" class="form-control" value="<?php echo BasicSettings::$smtp_secure ?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_smtp_port') ?></label>
                            <div class="col-md-9">
                                <input type="text" id="smtp_port" name="smtp_port" class="input-sm form-control" value="<?php echo BasicSettings::$smtp_port ?>" required />
                            </div>
                        </div>

                        <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                    </form>
                </div>
                <div id="cache" class="tab-pane fade">
                    <form id="form_cache" class="was-validated" name="form_cache" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_cache')">
                        <input hidden name="add" value="ok">

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_use_caching') ?></label>
                            <div class="col-md-9">
                                <select name="cache_status" id="cache_status" class="input-sm form-select">
                                    <option value="off"><?php echo lang('debug_off') ?></option>
                                    <option value="on" <?php echo Pages::selectedAttr(BasicSettings::$cache_status) ?>><?php echo lang('debug_on') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3"><?php echo lang('basic_settings_caching_time') ?></label>
                            <div class="col-md-9">
                                <input type="text" name="caching_time" class="input-sm form-control" value="<?php echo BasicSettings::$caching_time ?>" required />
                            </div>
                        </div>

                        <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                    </form>
                </div>

                <div id="logo" class="tab-pane fade">

                    <div id="alert_messages"></div>
                    <div class="mb-3">
                        <span class="badge rounded-pill text-bg-success"><?php echo lang('basic_settings_update_admin_logo') ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="col-md-3"><img src="/uploads/images/emarket_logo/admin_logo.png" class="img-thumbnail img-fluid float-start" /></label>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm bi-card-image" id="fileupload" type="button"> <?php echo lang('basic_settings_update_button_logo') ?></button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="badge rounded-pill text-bg-success"><?php echo lang('basic_settings_update_catalog_logo') ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="col-md-3"><img src="/uploads/images/emarket_logo/catalog_logo.png" class="img-thumbnail img-fluid float-start" /></label>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm bi-card-image" id="fileupload-product" type="button"> <?php echo lang('basic_settings_update_button_logo') ?></button>
                        </div>
                    </div>
                    <div id="mb-3 progress" class="progress mb-3" style="height: 1.5rem;">
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"></div>
                    </div>

                </div>

                <div id="update" class="tab-pane fade">
                    <div class="d-flex flex-row-reverse">
                        <span id="update_box" class="text-warning bi-broadcast" data-bs-toggle="tooltip" data-bs-placement="left"></span>
                    </div>

                    <div class="mb-3 row">
                        <p><?php echo lang('basic_settings_update_attention') ?></p>
                    </div>

                    <button class="btn btn-primary btn-sm bi-check-circle" id="update_button" type="button"> <?php echo lang('basic_settings_update_button') ?></button>
                </div>

            </div>    

        </div>
    </div>
</div>