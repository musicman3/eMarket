<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <?php
        

        //LOAD LANGUAGES LISTING
        require_once 'includes/languages_listing.php';

        //CHECK FORM
        require_once 'includes/check_form.js.php';

        ?>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="<?php echo $lang['meta-language'] ?>" />
        <meta name="robots" content="noindex,nofollow" />
        <meta name="generator" content="HippoEDIT, Netbeans, Notepad++" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />

        <title><?php echo $lang['title_login'] ?></title>
        <link href="../ext/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <link href="../ext/bootstrap/css/normalize.css" rel="stylesheet" media="screen" />
        <style type="text/css">body {padding-top:5px;}</style>
        
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="pull-left"><b><?php echo $lang['install_panel'] ?></b></div>
                            <div class="clearfix"></div>
                        </h3>
                    </div>
                    <div id="install" class="panel-body">
                    
			<form action="index.php" method="post" accept-charset="utf-8">
			    <div class="row">
				<div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<select name='language' class="input-sm form-control" onchange="submit();"><option value='<?php echo $dir_list[0] ?>'><?php echo $lang['select_language'] ?></option>
					<?php foreach ($dir_list as $keys => $value) { ?>
                                        <option value='<?php echo $value ?>'><?php echo ucfirst($value) ?></option>
					<?php } ?>
					</select>
				    </div>
				</div>
			    </div>
			</form>
			
                        <form action="install.php" name="form" method="post" accept-charset="utf-8" style="display: inline;" onsubmit="return check(this.email.value);">
                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['server_db'] ?>" type="text" name="server_db" />
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<select name="database_family" class="input-sm form-control"><option value='innodb'><?php echo $lang['database_innodb'] ?></option><option value='myisam'><?php echo $lang['database_myisam'] ?></option></select>
				    </div>
                                </div>
                             </div>

                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['login_db'] ?>" type="text" name="login_db" />
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<select name="hash_method" class="input-sm form-control"><option value='gost'><?php echo $lang['hash_gost'] ?></option><option value='sha256'><?php echo $lang['hash_sha256'] ?></option></select>
				    </div>
                                </div>
                             </div>
                             
                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['password_db'] ?>" type="password" name="password_db" />
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<select name="crypt_method" class="input-sm form-control"><option value='gost'><?php echo $lang['crypt_gost'] ?></option><option value='blowfish'><?php echo $lang['crypt_blowfish'] ?></option><option value='rijndael-256'><?php echo $lang['crypt_rijndael-256'] ?></option></select>
				    </div>
                                </div>
                             </div>
                             
                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['database_name'] ?>" type="text" name="database_name" />
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['login_admin'] ?>" type="text" name="login_admin" />
                                    </div>
                                </div>
                             </div>
                             
                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-success">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['database_prefix'] ?>" type="text" name="database_prefix" />
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['password_admin'] ?>" type="password" name="password_admin" />
                                    </div>
                                </div>
                             </div>
                             
                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-success">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['database_port'] ?>" type="text" name="database_port" />
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<input class="input-sm form-control" placeholder="<?php echo $lang['password_admin_confirm'] ?>" type="password" name="password_admin_confirm" />
                                    </div>
                                </div>
                             </div>
                             
                            <div class="row">
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<span class="input-group-addon"><span class="glyphicon glyphicon-hand-right"></span></span>
					<select name="database_type" class="input-sm form-control"><option value='mysql'><?php echo $lang['database_family_mysql'] ?></option></select>
                                    </div>
                                </div>
                                <div class="col-left form-group">
				    <div class="input-group has-error">
					<input type='hidden' name='language' value='<?php echo $deflang ?>' />
					<button class="btn btn-info btn-sm" type="submit" name="install_button" onclick="return pass_check();" /><?php echo $lang['install_button'] ?></button>
                                    </div>
                                </div>
                             </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div id="footerwrap">
            <footer class="clearfix"></footer>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p><img src="images/emarket.png" width="80" alt="" class="img-responsive center-block"></p>

                        <p>Copyright © 2018-<?php echo date('Y') ?> by <a href="#">eMarket Team</a>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
        <script type="text/javascript" src="../ext/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../ext/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>