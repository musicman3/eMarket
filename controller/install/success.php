<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

$ROOT = getenv('DOCUMENT_ROOT');
$crypt_method = \eMarket\Valid::inPOST('crypt_method');
$db_family = \eMarket\Valid::inPOST('database_family');
$db_name = \eMarket\Valid::inPOST('database_name');
$db_port = \eMarket\Valid::inPOST('database_port');
$db_pref = \eMarket\Valid::inPOST('database_prefix');
$db_type = \eMarket\Valid::inPOST('database_type');
$hash_method = \eMarket\Valid::inPOST('hash_method');
$http = 'http://' . \eMarket\Valid::inSERVER('HTTP_HOST') . '/';
$lng = strtolower(\eMarket\Valid::inPOST('language'));
$login_admin = \eMarket\Valid::inPOST('login_admin');
$login_db = \eMarket\Valid::inPOST('login_db');
$password_admin = \eMarket\Valid::inPOST('password_admin');
$password_db = \eMarket\Valid::inPOST('password_db');
$serv_db = \eMarket\Valid::inPOST('server_db');

$tab_admin = $db_pref . 'administrators';
$tab_basic_settings = $db_pref . 'basic_settings';
$tab_categories = $db_pref . 'categories';
$tab_countries = $db_pref . 'countries';
$tab_currencies = $db_pref . 'currencies';
$tab_customers = $db_pref . 'customers';
$tab_customers_activation = $db_pref . 'customers_activation';
$tab_length = $db_pref . 'length';
$tab_manufacturers = $db_pref . 'manufacturers';
$tab_modules = $db_pref . 'modules';
$tab_orders = $db_pref . 'orders';
$tab_order_status = $db_pref . 'order_status';
$tab_products = $db_pref . 'products';
$tab_password_recovery = $db_pref . 'password_recovery';
$tab_regions = $db_pref . 'regions';
$tab_stikers = $db_pref . 'stikers';
$tab_slideshow = $db_pref . 'slideshow';
$tab_slideshow_pref = $db_pref . 'slideshow_pref';
$tab_taxes = $db_pref . 'taxes';
$tab_template_constructor = $db_pref . 'template_constructor';
$tab_units = $db_pref . 'units';
$tab_vendor_codes = $db_pref . 'vendor_codes';
$tab_weight = $db_pref . 'weight';
$tab_zones = $db_pref . 'zones';
$tab_zones_value = $db_pref . 'zones_value';

$config = '<?php' . "\n" .
        '  define(\'HTTP_SERVER\', \'' . $http . '\');' . "\n" .
        '  define(\'ROOT\', \'' . $ROOT . '\');' . "\n" .
        '  define(\'DB_SERVER\', \'' . $serv_db . '\');' . "\n" .
        '  define(\'DB_USERNAME\', \'' . $login_db . '\');' . "\n" .
        '  define(\'DB_PASSWORD\', \'' . $password_db . '\');' . "\n" .
        '  define(\'DB_NAME\', \'' . $db_name . '\');' . "\n" .
        '  define(\'DB_FAMILY\', \'' . $db_family . '\');' . "\n" .
        '  define(\'DB_PREFIX\', \'' . $db_pref . '\');' . "\n" .
        '  define(\'DB_PORT\', \'' . $db_port . '\');' . "\n" .
        '  define(\'DB_TYPE\', \'' . $db_type . '\');' . "\n" .
        '  define(\'HASH_METHOD\', \'' . $hash_method . '\');' . "\n" .
        '  define(\'CRYPT_METHOD\', \'' . $crypt_method . '\');' . "\n" .
        '  define(\'TABLE_ADMINISTRATORS\', \'' . $tab_admin . '\');' . "\n" .
        '  define(\'TABLE_BASIC_SETTINGS\', \'' . $tab_basic_settings . '\');' . "\n" .
        '  define(\'TABLE_CATEGORIES\', \'' . $tab_categories . '\');' . "\n" .
        '  define(\'TABLE_COUNTRIES\', \'' . $tab_countries . '\');' . "\n" .
        '  define(\'TABLE_CURRENCIES\', \'' . $tab_currencies . '\');' . "\n" .
        '  define(\'TABLE_CUSTOMERS\', \'' . $tab_customers . '\');' . "\n" .
        '  define(\'TABLE_CUSTOMERS_ACTIVATION\', \'' . $tab_customers_activation . '\');' . "\n" .
        '  define(\'TABLE_LENGTH\', \'' . $tab_length . '\');' . "\n" .
        '  define(\'TABLE_MANUFACTURERS\', \'' . $tab_manufacturers . '\');' . "\n" .
        '  define(\'TABLE_MODULES\', \'' . $tab_modules . '\');' . "\n" .
        '  define(\'TABLE_ORDER_STATUS\', \'' . $tab_order_status . '\');' . "\n" .
        '  define(\'TABLE_ORDERS\', \'' . $tab_orders . '\');' . "\n" .
        '  define(\'TABLE_PRODUCTS\', \'' . $tab_products . '\');' . "\n" .
        '  define(\'TABLE_PASSWORD_RECOVERY\', \'' . $tab_password_recovery . '\');' . "\n" .
        '  define(\'TABLE_REGIONS\', \'' . $tab_regions . '\');' . "\n" .
        '  define(\'TABLE_STIKERS\', \'' . $tab_stikers . '\');' . "\n" .
        '  define(\'TABLE_SLIDESHOW\', \'' . $tab_slideshow . '\');' . "\n" .
        '  define(\'TABLE_SLIDESHOW_PREF\', \'' . $tab_slideshow_pref . '\');' . "\n" .
        '  define(\'TABLE_TAXES\', \'' . $tab_taxes . '\');' . "\n" .
        '  define(\'TABLE_TEMPLATE_CONSTRUCTOR\', \'' . $tab_template_constructor . '\');' . "\n" .
        '  define(\'TABLE_UNITS\', \'' . $tab_units . '\');' . "\n" .
        '  define(\'TABLE_VENDOR_CODES\', \'' . $tab_vendor_codes . '\');' . "\n" .
        '  define(\'TABLE_WEIGHT\', \'' . $tab_weight . '\');' . "\n" .
        '  define(\'TABLE_ZONES\', \'' . $tab_zones . '\');' . "\n" .
        '  define(\'TABLE_ZONES_VALUE\', \'' . $tab_zones_value . '\');' . "\n" .
        '?>';

$fpd = fopen($ROOT . '/model/configure/configure.php', 'w+');
fputs($fpd, $config);
fclose($fpd);

if (file_exists($ROOT . '/model/configure/configure.php')) {
    chmod($ROOT . '/model/configure/configure.php', 0644);
} else {
    header('Location: /controller/install/error.php?file_configure_not_found=true');
}

require_once($ROOT . '/model/configure/configure.php');

if ($db_type == 'mysql') {
    $file_name = ROOT . '/model/databases/mysql.sql';
}

if (!file_exists($file_name)) {
    header('Location: /controller/install/error.php?file_not_found=true');
}

$buffer = str_replace('emkt_', DB_PREFIX, implode(file($file_name)));

if ($db_family == 'myisam') {
    $buffer = str_ireplace('ENGINE=InnoDB', 'ENGINE=MyISAM', $buffer);
}

\eMarket\Pdo::getExec($buffer);

$password_admin_hash = \eMarket\Autorize::passwordHash($password_admin);

if (\eMarket\Valid::inPOST('login_admin') && \eMarket\Valid::inPOST('password_admin')) {
    \eMarket\Pdo::action("INSERT INTO " . TABLE_ADMINISTRATORS . "  SET login=?, password=?, permission=?, language=?", [$login_admin, $password_admin_hash, 'admin', $lng]);
    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [$lng]);
}

// .HTACCESS
$text = "#****** Copyright © 2018 eMarket ******#
#   GNU GENERAL PUBLIC LICENSE v.3.0   #
# https://github.com/musicman3/eMarket #
#**************************************#

RewriteEngine On
#Redirect
RewriteCond %{DOCUMENT_ROOT}/controller/catalog/$1 -d
RewriteRule ^(.*)$ controller/catalog/$1 [L,QSA]
RewriteCond %{DOCUMENT_ROOT}/controller/catalog/$1 -f
RewriteRule ^(.*)$ controller/catalog/$1 [L,QSA]";

$fp = fopen(ROOT . '/.htaccess', "w+");
fwrite($fp, $text);
fclose($fp);

if (file_exists(ROOT . '/.htaccess')) {
    chmod(ROOT . '/.htaccess', 0644);
}

\eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [$lng]);

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(getenv('DOCUMENT_ROOT') . '/model/end.php');
/* ------------------------------------------ */

