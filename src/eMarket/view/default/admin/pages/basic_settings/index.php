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
            </ul>

            <div class="tab-content pt-2">
                <div id="general" class="tab-pane fade show in active">
                    <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                        <input hidden name="add" value="ok">

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
            </div>    

        </div>
    </div>
</div>