<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="settings_basic_settings" class="container-fluid">
    <div class="panel panel-default">

        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <?php $MESSAGES->alert(); ?>
            <h3 class="panel-title">
                <div class="pull-left"><a class="btn btn-primary btn-xs" href="?route=settings"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_' . $SET->titleDir() . '_index') ?></div>
                <div class="clearfix"></div>
            </h3>
        </div>
        <br>
        <div>
            <!-- Панели -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#general"><?php echo lang('basic_settigs_general') ?></a></li>
                <li><a data-toggle="tab" href="#email"><?php echo lang('basic_settigs_email') ?></a></li>
            </ul>
        </div>

        <!-- Содержимое панелей -->
        <div class="tab-content">
            <!-- Основные настройки -->
            <div id="general" class="tab-pane fade in active">
                <form id="form_add" name="form_add" class="form-horizontal" action="javascript:void(null);" onsubmit="callAdd()">
                    <div class="panel-body">
                        <input hidden name="add" value="ok">

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('lines_on_page') ?></label></div>
                            <div class="col-sm-9">
                                <input type="text" name="lines_on_page" class="form-control" value="<?php echo $SET->linesOnPage() ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class=""><?php echo lang('session_expr_time') ?> <span data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('session_expr_time_help') ?>" class="glyphicon glyphicon-question-sign"></span></label></div>
                            <div class="col-sm-9">
                                <input type="text" name="session_expr_time" class="form-control" value="<?php echo $SET->sessionExprTime() ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class=""><?php echo lang('debug_info') ?></label></div>
                            <div class="col-sm-9">
                                <select name="debug" id="debug" class="input-sm form-control">
                                    <?php if ($debug == 1) { ?>
                                        <option selected><?php echo lang('debug_on') ?></option>
                                        <option><?php echo lang('debug_off') ?></option>
                                    <?php } else { ?>
                                        <option><?php echo lang('debug_on') ?></option>
                                        <option selected><?php echo lang('debug_off') ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                    </div>
                </form>
            </div>
            <!-- Настройки E-Mail -->
            <div id="email" class="tab-pane fade">
                <form id="form_email" name="form_email" class="form-horizontal" action="javascript:void(null);" onsubmit="callAdd('form_email')">
                    <div class="panel-body">
                        <input hidden name="add" value="ok">

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_email') ?></label></div>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" value="<?php echo $email ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_email_name') ?></label></div>
                            <div class="col-sm-9">
                                <input type="text" name="email_name" class="form-control" value="<?php echo $email_name ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class=""><?php echo lang('basic_settings_smtp_use') ?></label></div>
                            <div class="col-sm-9">
                                <select name="smtp_status" id="smtp_status" class="input-sm form-control">
                                    <?php if ($smtp_status == 1) { ?>
                                        <option selected><?php echo lang('debug_on') ?></option>
                                        <option><?php echo lang('debug_off') ?></option>
                                    <?php } else { ?>
                                        <option><?php echo lang('debug_on') ?></option>
                                        <option selected><?php echo lang('debug_off') ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class=""><?php echo lang('basic_settings_smtp_auth') ?></label></div>
                            <div class="col-sm-9">
                                <select name="smtp_auth" id="smtp_auth" class="input-sm form-control">
                                    <?php if ($smtp_auth == 1) { ?>
                                        <option selected><?php echo lang('debug_on') ?></option>
                                        <option><?php echo lang('debug_off') ?></option>
                                    <?php } else { ?>
                                        <option><?php echo lang('debug_on') ?></option>
                                        <option selected><?php echo lang('debug_off') ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_host_email') ?></label></div>
                            <div class="col-sm-9">
                                <input type="text" id="host_email" name="host_email" class="form-control" value="<?php echo $host_email ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_username_email') ?></label></div>
                            <div class="col-sm-9">
                                <input type="text" id="username_email" name="username_email" class="form-control" value="<?php echo $username_email ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_password_email') ?></label></div>
                            <div class="col-sm-9">
                                <input type="password" id="password_email" name="password_email" class="form-control" value="<?php echo $password_email ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_smtp_secure') ?></label></div>
                            <div class="col-sm-9">
                                <input type="text" id="smtp_secure" name="smtp_secure" class="form-control" value="<?php echo $smtp_secure ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 text-left"><label class="control-label"><?php echo lang('basic_settings_smtp_port') ?></label></div>
                            <div class="col-sm-9">
                                <input type="text" id="smtp_port" name="smtp_port" class="form-control" value="<?php echo $smtp_port ?>" required />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                    </div>
                </form>

            </div>
        </div>        

    </div>
</div>