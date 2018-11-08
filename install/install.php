<?php
// ****** Copyright © 2018 eMarket *****//
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <?php
        error_reporting(-1);

        require_once '../model/vendor/emarket/classes/core/valid.php';

        //ЗАГРУЖАЕМ CLASS Valid
        $VALID = new eMarket\Classes\Core\Valid;

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
        $logindb = $VALID->inPOST('login_db');
        $passdb = $VALID->inPOST('password_db');
        $dbname = $VALID->inPOST('database_name');
        $dbpref = $VALID->inPOST('database_prefix');
        $dbport = $VALID->inPOST('database_port');
        $dbtype = $VALID->inPOST('database_type');
        $dbfamyl = $VALID->inPOST('database_family');
        $logadm = $VALID->inPOST('login_admin');
        $pasadm = $VALID->inPOST('password_admin');
        $lng = $VALID->inPOST('language');
        $tabadm = $dbpref . 'administrators';
        $tab_cat = $dbpref . 'categories';
        $tab_countries = $dbpref . 'countries';
        $tab_products = $dbpref . 'products';
        $tab_regions = $dbpref . 'regions';
        $tab_taxes = $dbpref . 'taxes';
        $tab_units = $dbpref . 'units';
        $tab_zones = $dbpref . 'zones';
        $tab_countries_zones = $dbpref . 'countries_zones';
        $tab_regions_zones = $dbpref . 'regions_zones';
        $tab_vendor_codes = $dbpref . 'vendor_codes';
        $hashmet = $VALID->inPOST('hash_method');
        $crypt = $VALID->inPOST('crypt_method');

        $formhid = '<input type="hidden" name="language" value="' . $lng . '" />';

        //WRITE IN FILE CONFIGURE.PHP
        $datconf = '<?php' . "\n" .
                '  define(\'HTTP_SERVER\', \'' . $http . '\');' . "\n" .
                '  define(\'ROOT\', \'' . $root . '\');' . "\n" .
                '  define(\'DB_SERVER\', \'' . $serv_db . '\');' . "\n" .
                '  define(\'DB_USERNAME\', \'' . $logindb . '\');' . "\n" .
                '  define(\'DB_PASSWORD\', \'' . $passdb . '\');' . "\n" .
                '  define(\'DB_NAME\', \'' . $dbname . '\');' . "\n" .
                '  define(\'DB_PREFIX\', \'' . $dbpref . '\');' . "\n" .
                '  define(\'DB_PORT\', \'' . $dbport . '\');' . "\n" .
                '  define(\'DB_TYPE\', \'' . $dbtype . '\');' . "\n" .
                '  define(\'HASH_METHOD\', \'' . $hashmet . '\');' . "\n" .
                '  define(\'CRYPT_METHOD\', \'' . $crypt . '\');' . "\n" .
                '  define(\'DEFAULT_LANGUAGE\', \'' . $lng . '\');' . "\n" .
                '  define(\'TABLE_ADMINISTRATORS\', \'' . $tabadm . '\');' . "\n" .
                '  define(\'TABLE_CATEGORIES\', \'' . $tab_cat . '\');' . "\n" .
                '  define(\'TABLE_COUNTRIES\', \'' . $tab_countries . '\');' . "\n" .
                '  define(\'TABLE_PRODUCTS\', \'' . $tab_products . '\');' . "\n" .
                '  define(\'TABLE_REGIONS\', \'' . $tab_regions . '\');' . "\n" .
                '  define(\'TABLE_TAXES\', \'' . $tab_taxes . '\');' . "\n" .
                '  define(\'TABLE_UNITS\', \'' . $tab_units . '\');' . "\n" .
                '  define(\'TABLE_ZONES\', \'' . $tab_zones . '\');' . "\n" .
                '  define(\'TABLE_COUNTRIES_ZONES\', \'' . $tab_countries_zones . '\');' . "\n" .
                '  define(\'TABLE_REGIONS_ZONES\', \'' . $tab_regions_zones . '\');' . "\n" .
                '  define(\'TABLE_VENDOR_CODES\', \'' . $tab_vendor_codes . '\');' . "\n" .
                '?>';

        if (file_exists('../model/configure/configure.php') && !is_writeable('../model/configure/configure.php')) {
            chmod('../model/configure/configure.php', 0777);
        }

        if (file_exists('../model/configure/configure.php') && is_writeable('../model/configure/configure.php')) {
            $fp = fopen('../model/configure/configure.php', 'w');
            fputs($fp, $datconf);
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

        if ($dbfamyl == 'myisam') {
            $fname = "databases/" . $dbfamyl . ".sql";
        }
        if ($dbfamyl == 'innodb') {
            $fname = "databases/" . $dbfamyl . ".sql";
        }

        if (!file_exists($fname))
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

        $buffer = str_replace('emkt_', DB_PREFIX, implode(file($fname))); //REPLACE PREFIX
        $DB->exec("set names utf8mb4");
        $DB->exec($buffer);
//END IMPORT DB
//SAVE E-MAIL AND PASSWORD
        $pasadm2 = hash(HASH_METHOD, $pasadm);

        if ($VALID->inPOST('login_admin') and $VALID->inPOST('password_admin')) {
            $DB->exec("INSERT INTO " . TABLE_ADMINISTRATORS . " (login, password, permission, language) VALUES ('$logadm','$pasadm2','admin','$lng')");
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
                            <div class="alert alert-info"><?php echo $formhid ?></div>
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