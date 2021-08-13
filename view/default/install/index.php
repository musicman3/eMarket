<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title d-flex">
                <div class="me-auto d-flex align-items-center"><?php echo lang('install_panel') ?></div>
                <form action="index.php" method="post" accept-charset="utf-8">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bi-globe"></span>
                        <select name='language' class="input-sm form-select" onchange="submit();">
                            <option><?php echo lang('select_language') ?></option>
                            <?php for ($x = 0; $x < \eMarket\Core\Lang::$count; $x++) { ?>
                                <option value='<?php echo lang('#lang_all')[$x] ?>'><?php echo lang('language_name', lang('#lang_all')[$x]) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
            </h5>
        </div>
        <div class="card-body">
            <form class="was-validated" action="success.php" method="post" accept-charset="utf-8" oninput="validate()">
                <input type='hidden' name='language' value='<?php echo \eMarket\Install\Index::$DEFAULT_LANGUAGE ?>' />
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="server_db input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <input class="form-control" id="server_db" minlength="1" placeholder="<?php echo lang('server_db') ?>" type="text" name="server_db" required />
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <select name="database_family" class="form-select">
                                <option value='innodb'>-- <?php echo lang('database_family') ?> --</option>
                                <option value='innodb'><?php echo lang('database_innodb') ?></option>
                                <option value='myisam'><?php echo lang('database_myisam') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="login_db input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <input class="form-control" id="login_db" minlength="1" placeholder="<?php echo lang('login_db') ?>" type="text" name="login_db" required />
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-shield-lock"></span>
                            <select name="hash_method" class="form-select">
                                <option value='PASSWORD_DEFAULT'>-- <?php echo lang('hash_method') ?> --</option>
                                <option value='PASSWORD_DEFAULT'><?php echo lang('hash_recommended') ?></option>
                                <option value='PASSWORD_BCRYPT'><?php echo lang('hash_blowfish') ?></option>
                                <option value='PASSWORD_ARGON2I'><?php echo lang('hash_argon2i') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="database_name input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <input class="form-control" id="database_name" minlength="1" placeholder="<?php echo lang('database_name') ?>" type="text" name="database_name" required />
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-shield-lock"></span>
                            <select name="crypt_method" class="form-select">
                                <option value='chacha20-poly1305'>-- <?php echo lang('crypt_method') ?> --</option>
                                <option value='aes-256-cbc'>aes-256-cbc</option>
                                <option value='chacha20-poly1305'>chacha20-poly1305</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="password_db input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <input class="form-control" id="password_db" placeholder="<?php echo lang('password_db') ?>" type="password" name="password_db" required />
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="email input-group input-group-sm">
                            <span class="input-group-text bi-layout-text-sidebar"></span>
                            <input class="form-control" id="email" placeholder="<?php echo lang('login_admin') ?>" type="email" name="login_admin" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <input class="form-control" placeholder="<?php echo lang('database_prefix') ?>" type="text" name="database_prefix" value="emkt_" required />
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="password input-group input-group-sm">
                            <span class="input-group-text bi-layout-text-sidebar"></span>
                            <input class="form-control" id="password_admin" minlength="7" maxlength="40" placeholder="<?php echo lang('password_admin') ?>" type="password" name="password_admin" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <input class="form-control" placeholder="<?php echo lang('database_port') ?>" type="text" name="database_port" value="3306" required />
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="confirm input-group input-group-sm">
                            <span class="input-group-text bi-layout-text-sidebar"></span>
                            <input class="form-control" id="password_admin_confirm" minlength="7" maxlength="40" placeholder="<?php echo lang('password_admin_confirm') ?>" type="password" name="password_admin_confirm" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-4 mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-hdd"></span>
                            <select name="database_type" class="form-select">
                                <option value='mysql'>-- <?php echo lang('database_type') ?> --</option>
                                <option value='mysql'><?php echo lang('database_family_mysql') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 mb-2">
                            <button class="btn btn-primary btn-sm" type="submit" name="install_button" /><?php echo lang('install_button') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>