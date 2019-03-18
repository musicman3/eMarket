<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><?php echo lang('install_panel') ?></div>
                    
                <form action="index.php" method="post" accept-charset="utf-8">
                        <div class="add-xs">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                <select name='language' class="input-sm form-control" onchange="submit();">
                                    <option><?php echo lang('select_language') ?></option>
                                    <?php for ($x = 0; $x < $LANG_COUNT; $x++) { ?>
                                        <option value='<?php echo lang('#lang_all')[$x] ?>'><?php echo lang('language_name', lang('#lang_all')[$x]) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                </form>
                    
                    <div class="clearfix"></div>
                </h3>
            </div>

            <div class="panel-body">

                <form action="success.php" method="post" accept-charset="utf-8" style="display: inline;" onchange="validate()">

                    <!-- Выбранный язык" -->
                    <input type='hidden' name='language' value='<?php echo $DEFAULT_LANGUAGE ?>' />

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error server_db">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <input class="input-sm form-control" id="server_db" minlength="1" placeholder="<?php echo lang('server_db') ?>" type="text" name="server_db" required />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <select name="database_family" class="input-sm form-control">
                                    <option value='innodb'>-- <?php echo lang('database_family') ?> --</option>
                                    <option value='innodb'><?php echo lang('database_innodb') ?></option>
                                    <option value='myisam'><?php echo lang('database_myisam') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error login_db">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <input class="input-sm form-control" id="login_db" minlength="1" placeholder="<?php echo lang('login_db') ?>" type="text" name="login_db" required />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-tower"></span></span>
                                <select name="hash_method" class="input-sm form-control">
                                    <option value='PASSWORD_DEFAULT'>-- <?php echo lang('hash_method') ?> --</option>
                                    <option value='PASSWORD_BCRYPT'><?php echo lang('crypt_blowfish') ?></option>
                                    <option value='PASSWORD_ARGON2I'><?php echo lang('crypt_argon2i') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-error database_name">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <input class="input-sm form-control" id="database_name" minlength="1" placeholder="<?php echo lang('database_name') ?>" type="text" name="database_name" required />
                            </div>
                        </div>

                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-tower"></span></span>
                                <select name="crypt_method" class="input-sm form-control">
                                    <option value='gost'>-- <?php echo lang('crypt_method') ?> --</option>
                                    <option value='gost'><?php echo lang('crypt_gost') ?></option>
                                    <option value='blowfish'><?php echo lang('crypt_blowfish') ?></option>
                                    <option value='rijndael-256'><?php echo lang('crypt_rijndael-256') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('password_db') ?>" type="password" name="password_db" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error email">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" id="email" placeholder="<?php echo lang('login_admin') ?>" type="email" name="login_admin" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('database_prefix') ?>" type="text" name="database_prefix" value="emkt_" required />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error password">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" id="password_admin" minlength="7" maxlength="40" placeholder="<?php echo lang('password_admin') ?>" type="password" name="password_admin" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('database_port') ?>" type="text" name="database_port" value="3306" required />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error confirm">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
                                <input class="input-sm form-control" id="password_admin_confirm" minlength="7" maxlength="40" placeholder="<?php echo lang('password_admin_confirm') ?>" type="password" name="password_admin_confirm" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-left form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                                <select name="database_type" class="input-sm form-control">
                                    <option value='mysql'>-- <?php echo lang('database_type') ?> --</option>
                                    <option value='mysql'><?php echo lang('database_family_mysql') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <button class="btn btn-primary btn-sm" type="submit" name="install_button" /><?php echo lang('install_button') ?></button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>