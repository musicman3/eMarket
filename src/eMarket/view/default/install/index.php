<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-white bg-success">
            
            <div class="row">
                <h5 class="col"><?php echo lang('install_panel') ?></h5>
                <div class="col-xl-3 col-md-4 col-5 float-end">
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
                </div>
            </div>

        </div>
        <div class="card-body">

            <form class="was-validated" action="success.php" method="post" accept-charset="utf-8" oninput="validate()">
                <input type='hidden' name='language' value='<?php echo \eMarket\Install\Index::$default_language ?>' />

                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header text-white bg-success"><?php echo lang('database_text') ?></div>
                            <div class="card-body">
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('database_type') ?></small>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <select name="database_type" class="form-select">
                                            <option value='mysql'><?php echo lang('database_family_mysql') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('database_family') ?></small>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <select name="database_family" class="form-select">
                                            <option value='innodb'><?php echo lang('database_innodb') ?></option>
                                            <option value='myisam'><?php echo lang('database_myisam') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('server_db') ?></small>
                                    <div class="server_db input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <input class="form-control" id="server_db" minlength="1" placeholder="<?php echo lang('server_db') ?>" type="text" name="server_db" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('database_port') ?></small>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <input class="form-control" placeholder="<?php echo lang('database_port') ?>" type="text" name="database_port" value="3306" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('database_name') ?></small>
                                    <div class="database_name input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <input class="form-control" id="database_name" minlength="1" placeholder="<?php echo lang('database_name') ?>" type="text" name="database_name" value="emarket_db" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('database_prefix') ?></small>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <input class="form-control" placeholder="<?php echo lang('database_prefix') ?>" type="text" name="database_prefix" value="emkt_" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('login_db') ?></small>
                                    <div class="login_db input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <input class="form-control" id="login_db" minlength="1" placeholder="<?php echo lang('login_db') ?>" type="text" name="login_db" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('password_db') ?></small>
                                    <div class="password_db input-group input-group-sm">
                                        <span class="input-group-text bi-hdd"></span>
                                        <input class="form-control" id="password_db" placeholder="<?php echo lang('password_db') ?>" type="password" name="password_db" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header text-white bg-success"><?php echo lang('database_security_text') ?></div>
                            <div class="card-body">
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('hash_method') ?></small>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bi-shield-lock"></span>
                                        <select name="hash_method" class="form-select">
                                            <option value='PASSWORD_DEFAULT'><?php echo lang('hash_recommended') ?></option>
                                            <option value='PASSWORD_BCRYPT'><?php echo lang('hash_blowfish') ?></option>
                                            <option value='PASSWORD_ARGON2I'><?php echo lang('hash_argon2i') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('crypt_method') ?></small>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bi-shield-lock"></span>
                                        <select name="crypt_method" class="form-select">
                                            <option value='aes-256-gcm'>aes-256-gcm</option>
                                            <option value='chacha20-poly1305'>chacha20-poly1305</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('login_admin') ?></small>
                                    <div class="email input-group input-group-sm">
                                        <span class="input-group-text bi-person-fill"></span>
                                        <input class="form-control" id="email" placeholder="<?php echo lang('login_admin') ?>" type="email" name="login_admin" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('password_admin') ?></small>
                                    <div class="password input-group input-group-sm">
                                        <span class="input-group-text bi-key"></span>
                                        <input class="form-control" id="password_admin" minlength="7" maxlength="40" placeholder="<?php echo lang('password_admin') ?>" type="password" name="password_admin" required />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <small class="form-text text-muted"><?php echo lang('password_admin_confirm') ?></small>
                                    <div class="confirm input-group input-group-sm">
                                        <span class="input-group-text bi-key"></span>
                                        <input class="form-control" id="password_admin_confirm" minlength="7" maxlength="40" placeholder="<?php echo lang('password_admin_confirm') ?>" type="password" name="password_admin_confirm" required />
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="d-grid">
                                        <button class="btn btn-danger btn-sm" type="submit" name="install_button" /><?php echo lang('install_button') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header text-white bg-success"><?php echo lang('server_current_settings') ?></div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col">PHP:</div>
                                        <div class="col text-end"><?php echo PHP_VERSION ?> <span class="<?php echo $eMarket->phpVersionCompare() ?>"></span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">curl:</div>
                                        <div class="col text-end"><span class="<?php echo $eMarket->phpExtension('curl') ?>"></span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">gd:</div>
                                        <div class="col text-end"><span class="<?php echo $eMarket->phpExtension('gd') ?>"></span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">json:</div>
                                        <div class="col text-end"><span class="<?php echo $eMarket->phpExtension('json') ?>"></span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">pdo_mysql:</div>
                                        <div class="col text-end"><span class="<?php echo $eMarket->phpExtension('pdo_mysql') ?>"></span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">SPL:</div>
                                        <div class="col text-end"><span class="<?php echo $eMarket->phpExtension('SPL') ?>"></span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">max_input_vars:</div>
                                        <div class="col text-end"><?php echo ini_get('max_input_vars') ?> <span class="<?php echo $eMarket->phpIniGet('max_input_vars', 5000) ?>"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header text-white bg-success"><?php echo lang('from_developers') ?></div>
                            <div class="card-body">
                                <div class="mb-2"><p><em><?php echo lang('emarket_text') ?></em></p></div>
                                <div class="mb-2 text-center"><p><a href="https://www.buymeacoffee.com/emarket" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-violet.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;" ></a></p></div>
                                <div class="mb-2 text-center"><p><em><?php echo lang('emarket_best_regards') ?></em></p></div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
