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
        error_reporting(-1);

        require_once '../model/autoloader.php';

        //LOAD LANGUAGE
        require_once 'language/' . $VALID->inPOST('language') . '.php';

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

        <?php
        $http = 'http://' . $VALID->inSERVER('HTTP_HOST');

        if ($VALID->inSERVER('REQUEST_URI') && (empty($VALID->inSERVER('REQUEST_URI')) === false)) {
            $http .= $VALID->inSERVER('REQUEST_URI');
        } else {
            $http .= $VALID->inSERVER('SCRIPT_FILENAME');
        }

        //IMPORT CONFIGURE
        $http = substr($http, 0, strpos($http, 'install'));
        $root = getenv('DOCUMENT_ROOT');
        $serv_db = $VALID->inPOST('server_db');
        $login_db = $VALID->inPOST('login_db');
        $password_db = $VALID->inPOST('password_db');
        $db_name = $VALID->inPOST('database_name');
        $db_pref = $VALID->inPOST('database_prefix');
        $db_port = $VALID->inPOST('database_port');
        $db_type = $VALID->inPOST('database_type');
        $db_famyly = $VALID->inPOST('database_family');
        $login_admin = $VALID->inPOST('login_admin');
        $password_admin = $VALID->inPOST('password_admin');
        $lng = $VALID->inPOST('language');
        $tab_admin = $db_pref . 'administrators';
        $tab_categories = $db_pref . 'categories';
        $tab_countries = $db_pref . 'countries';
        $tab_products = $db_pref . 'products';
        $tab_regions = $db_pref . 'regions';
        $tab_taxes = $db_pref . 'taxes';
        $tab_units = $db_pref . 'units';
        $tab_zones = $db_pref . 'zones';
        $tab_zones_value = $db_pref . 'zones_value';
        $tab_vendor_codes = $db_pref . 'vendor_codes';
        $hash_method = $VALID->inPOST('hash_method');
        $crypt_method = $VALID->inPOST('crypt_method');

        $form_hidden = '<input type="hidden" name="language" value="' . $lng . '" />';

        //WRITE IN FILE CONFIGURE.PHP
        $config = '<?php' . "\n" .
                '  define(\'HTTP_SERVER\', \'' . $http . '\');' . "\n" .
                '  define(\'ROOT\', \'' . $root . '\');' . "\n" .
                '  define(\'DB_SERVER\', \'' . $serv_db . '\');' . "\n" .
                '  define(\'DB_USERNAME\', \'' . $login_db . '\');' . "\n" .
                '  define(\'DB_PASSWORD\', \'' . $password_db . '\');' . "\n" .
                '  define(\'DB_NAME\', \'' . $db_name . '\');' . "\n" .
                '  define(\'DB_PREFIX\', \'' . $db_pref . '\');' . "\n" .
                '  define(\'DB_PORT\', \'' . $db_port . '\');' . "\n" .
                '  define(\'DB_TYPE\', \'' . $db_type . '\');' . "\n" .
                '  define(\'HASH_METHOD\', \'' . $hash_method . '\');' . "\n" .
                '  define(\'CRYPT_METHOD\', \'' . $crypt_method . '\');' . "\n" .
                '  define(\'DEFAULT_LANGUAGE\', \'' . $lng . '\');' . "\n" .
                '  define(\'TABLE_ADMINISTRATORS\', \'' . $tab_admin . '\');' . "\n" .
                '  define(\'TABLE_CATEGORIES\', \'' . $tab_categories . '\');' . "\n" .
                '  define(\'TABLE_COUNTRIES\', \'' . $tab_countries . '\');' . "\n" .
                '  define(\'TABLE_PRODUCTS\', \'' . $tab_products . '\');' . "\n" .
                '  define(\'TABLE_REGIONS\', \'' . $tab_regions . '\');' . "\n" .
                '  define(\'TABLE_TAXES\', \'' . $tab_taxes . '\');' . "\n" .
                '  define(\'TABLE_UNITS\', \'' . $tab_units . '\');' . "\n" .
                '  define(\'TABLE_VENDOR_CODES\', \'' . $tab_vendor_codes . '\');' . "\n" .
                '  define(\'TABLE_ZONES\', \'' . $tab_zones . '\');' . "\n" .
                '  define(\'TABLE_ZONES_VALUE\', \'' . $tab_zones_value . '\');' . "\n" .
                '?>';

        if (file_exists('../model/configure/configure.php') && !is_writeable('../model/configure/configure.php')) {
            chmod('../model/configure/configure.php', 0777);
        }

        if (file_exists('../model/configure/configure.php') && is_writeable('../model/configure/configure.php')) {
            $fp = fopen('../model/configure/configure.php', 'w');
            fputs($fp, $config);
            fclose($fp);
        } else {

            echo '
<div class="container">
        <div class="row">
	          <div class="panel panel-default">
	          
			 <div class="panel-heading">
				<h3 class="panel-title">
				      <div class="pull-left"><b>' . $lang['install_panel'] . '</b></div>
				      <div class="clearfix"></div>
				</h3>
			</div>
<div class="panel-body">
    <form style="display: inline;" action="index.php" method="post" accept-charset="utf-8">
        <div class="alert alert-warning">' . $lang['file_configure_not_found'] . '</div>
        <button class="btn btn-info btn-sm" type="submit" />' . $lang["button_go_login"] . '</button>
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

                    <p>Copyright © 2018-' . date('Y') . ' by <a href="#">eMarket Team</a>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
			<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
			<script type="text/javascript" src="../ext/jquery/jquery.min.js"></script>
			<script type="text/javascript" src="../ext/bootstrap/js/bootstrap.min.js"></script>
';
            exit;
        }

        //REQUIRE CONFIGURE.PHP
        require_once('../model/configure/configure.php');

        $DB = new PDO(DB_TYPE . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);

        if (!$DB) {

            ?>

            <div class="container">
                <div class="row">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <div class="pull-left"><b><?php echo $lang['install_panel'] ?></b></div>
                                <div class="clearfix"></div>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form action='index.php' method='post' accept-charset='utf-8' style='display: inline;'>
                                <div class="alert alert-warning"><?php echo $lang['server_db_error'] ?></div>
                                <button class="btn btn-info btn-sm" type="submit" name="button_go_login" /><?php echo $lang['button_go_login'] ?></button>
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

                            <p>Copyright (c) 2018-<?php echo date('Y') ?>, <a href="#">eMarket Team</a>. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
            <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
            <script type="text/javascript" src="../ext/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="../ext/bootstrap/js/bootstrap.min.js"></script>
            <?php
            exit();
        }

        if ($db_famyly == 'myisam') {
            $file_name = "databases/" . $db_famyly . ".sql";
        }
        if ($db_famyly == 'innodb') {
            $file_name = "databases/" . $db_famyly . ".sql";
        }

        if (!file_exists($file_name))
            die('
<div class="container">
        <div class="row">
	          <div class="panel panel-default">
	          
			 <div class="panel-heading">
				<h3 class="panel-title">
				      <div class="pull-left"><b>' . $lang['install_panel'] . '</b></div>
				      <div class="clearfix"></div>
				</h3>
			</div>
<div class="panel-body">
<form style="display: inline;" action="index.php" method="post" accept-charset="utf-8">
<div class="alert alert-warning">' . $lang['file_not_found'] . '</div>
<button class="btn btn-info btn-sm" type="submit" />' . $lang["button_go_login"] . '</button>
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

                    <p>Copyright © 2018-' . date('Y') . ' by <a href="#">eMarket Team</a>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
			<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
			<script type="text/javascript" src="../ext/jquery/jquery.min.js"></script>
			<script type="text/javascript" src="../ext/bootstrap/js/bootstrap.min.js"></script>
');

        $buffer = str_replace('emkt_', DB_PREFIX, implode(file($file_name))); //REPLACE PREFIX
        $DB->exec("set names utf8mb4");
        $DB->exec($buffer);
//END IMPORT DB
//SAVE E-MAIL AND PASSWORD
        $pasadm2 = hash(HASH_METHOD, $password_admin);

        if ($VALID->inPOST('login_admin') and $VALID->inPOST('password_admin')) {
            $DB->exec("INSERT INTO " . TABLE_ADMINISTRATORS . " (login, password, permission, language) VALUES ('$login_admin','$pasadm2','admin','$lng')");
        }

        $DB = null;

// СОЗДАЕМ .HTACCESS
        $text = "#****** Copyright © 2018 eMarket ******#
#   GNU GENERAL PUBLIC LICENSE v.3.0   #
# https://github.com/musicman3/eMarket #
#**************************************#
		
php_flag ignore_repeated_errors off
php_flag ignore_repeated_source off
php_flag track_errors on
php_flag display_errors on
php_flag display_startup_errors on
php_flag log_errors on
php_flag mysql.trace_mode on
php_value error_reporting -1
php_value error_log " . ROOT . "/model/work/errors.log";


        //Если файл существует, то ставим права 777
        if (file_exists('../.htaccess') && !is_writeable('../.htaccess')) {
            chmod('../.htaccess', 0777);
        }
        // открываем файл, если файл не существует, то делается попытка создать его
        $fp = fopen(ROOT . '/.htaccess', "w");

        // записываем в файл текст
        fwrite($fp, $text);
        fclose($fp);

        ?>

        <div class="container">
            <div class="row">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="pull-left"><b><?php echo $lang['install_panel'] ?></b></div>
                            <div class="clearfix"></div>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action='../controller/admin/login/' method='post' accept-charset='utf-8' style='display: inline;'>
                            <div class="alert alert-success"><?php echo $lang['success'] ?></div>
                            <div class="alert alert-info"><?php echo $form_hidden ?></div>
                            <button class="btn btn-info btn-sm" type="submit" name="button_go_login" /><?php echo $lang['button_go_login'] ?></button>
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

                        <p>Copyright (c) 2018-<?php echo date('Y') ?>, <a href="#">eMarket Team</a>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
        <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
        <script type="text/javascript" src="../ext/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../ext/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>