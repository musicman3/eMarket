<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

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
            <div class="panel-body">
                <form action="install.php" method="post" accept-charset="utf-8" style="display: inline;" onsubmit="return check(this.email.value);">
                    <div style="float:left;margin-right:50px;">
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('server_db') ?>:</label>
                            <div class="controls"><input type='text' name='server_db' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('login_db') ?>:</label>
                            <div class="controls"><input type='text' name='login_db' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('password_db') ?>:</label>
                            <div class="controls"><input type='password' name='password_db' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('database_name') ?>:</label>
                            <div class="controls"><input type='text' name='database_name' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('database_prefix') ?>:</label>
                            <div class="controls"><input type='text' name='database_prefix' value='emkt_' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('database_port') ?>:</label>
                            <div class="controls"><input type='text' name='database_port' value='3306' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('database_type') ?>:</label>
                            <div class="controls"><select name='database_type'><option value='mysql'><?php echo lang('database_family_mysql') ?></option></select></div>
                        </div>
                    </div>
                    <div style="float:left;">
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('database_family') ?>:</label>
                            <div class="controls"><select name='database_family'><option value='innodb'><?php echo lang('database_innodb') ?></option><option value='myisam'><?php echo lang('database_myisam') ?></option></select></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('hash_method') ?>:</label>
                            <div class="controls"><select name='hash_method'><option value='gost'><?php echo lang('hash_gost') ?></option><option value='sha256'><?php echo lang('hash_sha256') ?></option></select></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('crypt_method') ?>:</label>
                            <div class="controls"><select name='crypt_method'><option value='gost'><?php echo lang('crypt_gost') ?></option><option value='blowfish'><?php echo lang('crypt_blowfish') ?></option><option value='rijndael-256'><?php echo lang('crypt_rijndael-256') ?></option></select></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('login_admin') ?>:</label>
                            <div class="controls"><input id="email" type='text' name='login_admin' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('password_admin') ?>:</label>
                            <div class="controls"><input id="password_admin" type='password' name='password_admin' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo lang('password_admin_confirm') ?>:</label>
                            <div class="controls"><input id="password_admin_confirm" type='password' name='password_admin_confirm' /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><input type='hidden' name='language' value='<?php echo $DEFAULT_LANGUAGE ?>' /></label>
                            <div class="controls"><button class="btn btn-info btn-sm" type="submit" name="install_button" onclick="return pass_check();" /><?php echo lang('install_button') ?></button></div>
                        </div>
                    </div>
                </form>
            </div>


            <form action="index.php" method="post" accept-charset="utf-8">
                <div class="control-group">
                    <div style="margin-left: 15px;margin-bottom: 15px;" class="controls"><select name='language' onchange="submit();">
                            <option><?php echo lang('select_language') ?></option>
                            <?php for ($x=1; $x<count($lang_all); $x++) { ?>
                                <option value='<?php echo $lang_all[$x] ?>'><?php echo ucfirst($lang_all[$x]) ?></option>
                            <?php } ?>
                        </select></div>
                </div>
            </form>
        </div>
    </div>
</div>