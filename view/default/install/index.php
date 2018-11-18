<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><b><?php echo lang('install_panel') ?></b></div>
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div id="install" class="panel-body">

                <form action="index.php" method="post" accept-charset="utf-8">
                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <select name='language' class="input-sm form-control" onchange="submit();">
                                    <option><?php echo lang('select_language') ?></option>
                                    <?php for ($x = 1; $x < count($lang_all); $x++) { ?>
                                        <option value='<?php echo $lang_all[$x] ?>'><?php echo $lang_all[$x] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="install.php" name="form" method="post" accept-charset="utf-8" style="display: inline;" onsubmit="return check(this.email.value);">
                    
                    <!-- Выбранный язык" -->
                    <input type='hidden' name='language' value='<?php echo $DEFAULT_LANGUAGE ?>' />
                    
                    <!-- Значения по умолчанию, если не выбраны" -->
                    <input type='hidden' name='database_family' value='<?php echo lang('database_innodb') ?>' />
                    <input type='hidden' name='hash_method' value='<?php echo lang('hash_gost') ?>' />
                    <input type='hidden' name='crypt_method' value='<?php echo lang('crypt_gost') ?>' />
                    <input type='hidden' name='database_type' value='<?php echo lang('database_family_mysql') ?>' />
                    
                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('server_db') ?>" type="text" name="server_db" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <select name="database_family" class="input-sm form-control">
                                    <option>-- <?php echo lang('database_family') ?> --</option>
                                    <option value='innodb'><?php echo lang('database_innodb') ?></option>
                                    <option value='myisam'><?php echo lang('database_myisam') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('login_db') ?>" type="text" name="login_db" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <select name="hash_method" class="input-sm form-control">
                                    <option>-- <?php echo lang('hash_method') ?> --</option>
                                    <option value='gost'><?php echo lang('hash_gost') ?></option>
                                    <option value='sha256'><?php echo lang('hash_sha256') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('password_db') ?>" type="password" name="password_db" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <select name="crypt_method" class="input-sm form-control">
                                    <option>-- <?php echo lang('crypt_method') ?> --</option>
                                    <option value='gost'><?php echo lang('crypt_gost') ?></option>
                                    <option value='blowfish'><?php echo lang('crypt_blowfish') ?></option>
                                    <option value='rijndael-256'><?php echo lang('crypt_rijndael-256') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('database_name') ?>" type="text" name="database_name" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('login_admin') ?>" type="text" name="login_admin" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('database_prefix') ?>" type="text" name="database_prefix" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('password_admin') ?>" type="password" name="password_admin" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('database_port') ?>" type="text" name="database_port" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('password_admin_confirm') ?>" type="password" name="password_admin_confirm" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <select name="database_type" class="input-sm form-control">
                                    <option>-- <?php echo lang('database_type') ?> --</option>
                                    <option value='mysql'><?php echo lang('database_family_mysql') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <button class="btn btn-info btn-sm" type="submit" name="install_button" onclick="return pass_check();" /><?php echo lang('install_button') ?></button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>