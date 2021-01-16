<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Install;

/**
 * Success
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Success {

    public static $lng;
    public static $ROOT;
    public static $login_admin;
    public static $password_admin;
    public static $config;
    public static $db_type;
    public static $db_family;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->config();
        $this->save();
    }

    /**
     * Config
     *
     */
    public function config() {
        self::$ROOT = getenv('DOCUMENT_ROOT');
        self::$db_family = \eMarket\Valid::inPOST('database_family');
        $db_pref = \eMarket\Valid::inPOST('database_prefix');
        self::$db_type = \eMarket\Valid::inPOST('database_type');
        self::$lng = strtolower(\eMarket\Valid::inPOST('language'));
        self::$login_admin = \eMarket\Valid::inPOST('login_admin');
        self::$password_admin = \eMarket\Valid::inPOST('password_admin');

        self::$config = '<?php' . "\n" .
                '  define(\'HTTP_SERVER\', \'' . 'http://' . \eMarket\Valid::inSERVER('HTTP_HOST') . '/' . '\');' . "\n" .
                '  define(\'ROOT\', \'' . self::$ROOT . '\');' . "\n" .
                '  define(\'DB_SERVER\', \'' . \eMarket\Valid::inPOST('server_db') . '\');' . "\n" .
                '  define(\'DB_USERNAME\', \'' . \eMarket\Valid::inPOST('login_db') . '\');' . "\n" .
                '  define(\'DB_PASSWORD\', \'' . \eMarket\Valid::inPOST('password_db') . '\');' . "\n" .
                '  define(\'DB_NAME\', \'' . \eMarket\Valid::inPOST('database_name') . '\');' . "\n" .
                '  define(\'DB_FAMILY\', \'' . self::$db_family . '\');' . "\n" .
                '  define(\'DB_PREFIX\', \'' . $db_pref . '\');' . "\n" .
                '  define(\'DB_PORT\', \'' . \eMarket\Valid::inPOST('database_port') . '\');' . "\n" .
                '  define(\'DB_TYPE\', \'' . self::$db_type . '\');' . "\n" .
                '  define(\'HASH_METHOD\', \'' . \eMarket\Valid::inPOST('hash_method') . '\');' . "\n" .
                '  define(\'CRYPT_METHOD\', \'' . \eMarket\Valid::inPOST('crypt_method') . '\');' . "\n" .
                '  define(\'TABLE_ADMINISTRATORS\', \'' . $db_pref . 'administrators' . '\');' . "\n" .
                '  define(\'TABLE_BASIC_SETTINGS\', \'' . $db_pref . 'basic_settings' . '\');' . "\n" .
                '  define(\'TABLE_CATEGORIES\', \'' . $db_pref . 'categories' . '\');' . "\n" .
                '  define(\'TABLE_COUNTRIES\', \'' . $db_pref . 'countries' . '\');' . "\n" .
                '  define(\'TABLE_CURRENCIES\', \'' . $db_pref . 'currencies' . '\');' . "\n" .
                '  define(\'TABLE_CUSTOMERS\', \'' . $db_pref . 'customers' . '\');' . "\n" .
                '  define(\'TABLE_CUSTOMERS_ACTIVATION\', \'' . $db_pref . 'customers_activation' . '\');' . "\n" .
                '  define(\'TABLE_LENGTH\', \'' . $db_pref . 'length' . '\');' . "\n" .
                '  define(\'TABLE_MANUFACTURERS\', \'' . $db_pref . 'manufacturers' . '\');' . "\n" .
                '  define(\'TABLE_MODULES\', \'' . $db_pref . 'modules' . '\');' . "\n" .
                '  define(\'TABLE_ORDER_STATUS\', \'' . $db_pref . 'order_status' . '\');' . "\n" .
                '  define(\'TABLE_ORDERS\', \'' . $db_pref . 'orders' . '\');' . "\n" .
                '  define(\'TABLE_PRODUCTS\', \'' . $db_pref . 'products' . '\');' . "\n" .
                '  define(\'TABLE_PASSWORD_RECOVERY\', \'' . $db_pref . 'password_recovery' . '\');' . "\n" .
                '  define(\'TABLE_REGIONS\', \'' . $db_pref . 'regions' . '\');' . "\n" .
                '  define(\'TABLE_STIKERS\', \'' . $db_pref . 'stikers' . '\');' . "\n" .
                '  define(\'TABLE_SLIDESHOW\', \'' . $db_pref . 'slideshow' . '\');' . "\n" .
                '  define(\'TABLE_SLIDESHOW_PREF\', \'' . $db_pref . 'slideshow_pref' . '\');' . "\n" .
                '  define(\'TABLE_TAXES\', \'' . $db_pref . 'taxes' . '\');' . "\n" .
                '  define(\'TABLE_TEMPLATE_CONSTRUCTOR\', \'' . $db_pref . 'template_constructor' . '\');' . "\n" .
                '  define(\'TABLE_UNITS\', \'' . $db_pref . 'units' . '\');' . "\n" .
                '  define(\'TABLE_VENDOR_CODES\', \'' . $db_pref . 'vendor_codes' . '\');' . "\n" .
                '  define(\'TABLE_WEIGHT\', \'' . $db_pref . 'weight' . '\');' . "\n" .
                '  define(\'TABLE_ZONES\', \'' . $db_pref . 'zones' . '\');' . "\n" .
                '  define(\'TABLE_ZONES_VALUE\', \'' . $db_pref . 'zones_value' . '\');' . "\n" .
                '?>';
    }

    /**
     * Save
     *
     */
    public function save() {
        $fpd = fopen(self::$ROOT . '/model/configure/configure.php', 'w+');
        fputs($fpd, self::$config);
        fclose($fpd);

        if (file_exists(self::$ROOT . '/model/configure/configure.php')) {
            chmod(self::$ROOT . '/model/configure/configure.php', 0644);
        } else {
            header('Location: /controller/install/error.php?file_configure_not_found=true');
        }

        require_once(self::$ROOT . '/model/configure/configure.php');

        if (self::$db_type == 'mysql') {
            $file_name = ROOT . '/model/databases/mysql.sql';
        }

        if (!file_exists($file_name)) {
            header('Location: /controller/install/error.php?file_not_found=true');
        }

        $buffer = str_replace('emkt_', DB_PREFIX, implode(file($file_name)));

        if (self::$db_family == 'myisam') {
            $buffer = str_ireplace('ENGINE=InnoDB', 'ENGINE=MyISAM', $buffer);
        }

        \eMarket\Pdo::getExec($buffer);

        $password_admin_hash = \eMarket\Autorize::passwordHash(self::$password_admin);

        if (\eMarket\Valid::inPOST('login_admin') && \eMarket\Valid::inPOST('password_admin')) {
            \eMarket\Pdo::action("INSERT INTO " . TABLE_ADMINISTRATORS . "  SET login=?, password=?, permission=?, language=?", [self::$login_admin, $password_admin_hash, 'admin', self::$lng]);
            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [self::$lng]);
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

        \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [self::$lng]);
    }

}
