<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Install;

use eMarket\Core\{
    Authorize,
    Pdo,
    Valid
};

/**
 * Success
 *
 * @package Install
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Success {

    public static $routing_parameter = 'success';
    public $title = 'title_success';
    public static $lng;
    public static $root;
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
    private function config(): void {
        self::$root = getenv('DOCUMENT_ROOT');
        self::$db_family = Valid::inPOST('database_family');
        $db_pref = Valid::inPOST('database_prefix');
        self::$db_type = Valid::inPOST('database_type');
        self::$lng = strtolower(Valid::inPOST('language'));
        self::$login_admin = Valid::inPOST('login_admin');
        self::$password_admin = Valid::inPOST('password_admin');

        self::$config = '<?php' . "\n" .
                '  define(\'HTTP_SERVER\', \'' . 'http://' . Valid::inSERVER('HTTP_HOST') . '/' . '\');' . "\n" .
                '  define(\'ROOT\', \'' . self::$root . '\');' . "\n" .
                '  define(\'DB_SERVER\', \'' . Valid::inPOST('server_db') . '\');' . "\n" .
                '  define(\'DB_USERNAME\', \'' . Valid::inPOST('login_db') . '\');' . "\n" .
                '  define(\'DB_PASSWORD\', \'' . Valid::inPOST('password_db') . '\');' . "\n" .
                '  define(\'DB_NAME\', \'' . Valid::inPOST('database_name') . '\');' . "\n" .
                '  define(\'DB_FAMILY\', \'' . self::$db_family . '\');' . "\n" .
                '  define(\'DB_PREFIX\', \'' . $db_pref . '\');' . "\n" .
                '  define(\'DB_PORT\', \'' . Valid::inPOST('database_port') . '\');' . "\n" .
                '  define(\'DB_TYPE\', \'' . self::$db_type . '\');' . "\n" .
                '  define(\'HASH_METHOD\', \'' . Valid::inPOST('hash_method') . '\');' . "\n" .
                '  define(\'CRYPT_METHOD\', \'' . Valid::inPOST('crypt_method') . '\');' . "\n" .
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
                '  define(\'TABLE_REVIEWS\', \'' . $db_pref . 'reviews' . '\');' . "\n" .
                '  define(\'TABLE_STICKERS\', \'' . $db_pref . 'stickers' . '\');' . "\n" .
                '  define(\'TABLE_SLIDESHOW\', \'' . $db_pref . 'slideshow' . '\');' . "\n" .
                '  define(\'TABLE_SLIDESHOW_PREF\', \'' . $db_pref . 'slideshow_pref' . '\');' . "\n" .
                '  define(\'TABLE_STAFF_MANAGER\', \'' . $db_pref . 'staff_manager' . '\');' . "\n" .
                '  define(\'TABLE_STAFF\', \'' . $db_pref . 'staff' . '\');' . "\n" .
                '  define(\'TABLE_TAXES\', \'' . $db_pref . 'taxes' . '\');' . "\n" .
                '  define(\'TABLE_TEMPLATE_CONSTRUCTOR\', \'' . $db_pref . 'template_constructor' . '\');' . "\n" .
                '  define(\'TABLE_UNITS\', \'' . $db_pref . 'units' . '\');' . "\n" .
                '  define(\'TABLE_VENDOR_CODES\', \'' . $db_pref . 'vendor_codes' . '\');' . "\n" .
                '  define(\'TABLE_WEIGHT\', \'' . $db_pref . 'weight' . '\');' . "\n" .
                '  define(\'TABLE_ZONES\', \'' . $db_pref . 'zones' . '\');' . "\n" .
                '  define(\'TABLE_ZONES_VALUE\', \'' . $db_pref . 'zones_value' . '\');' . "\n";
    }

    /**
     * Save
     *
     */
    private function save(): void {
        $fpd = fopen(self::$root . '/storage/configure/configure.php', 'w+');
        fputs($fpd, self::$config);
        fclose($fpd);

        if (file_exists(self::$root . '/storage/configure/configure.php')) {
            chmod(self::$root . '/storage/configure/configure.php', 0644);
        } else {
            header('Location: /controller/install/?route=error&file_configure_not_found=true');
            exit;
        }

        require_once(self::$root . '/storage/configure/configure.php');

        if (self::$db_type == 'mysql') {
            $file_name = ROOT . '/storage/databases/mysql.sql';
        }

        if (!file_exists($file_name)) {
            header('Location: /controller/install/?route=error&file_not_found=true');
            exit;
        }

        $buffer = str_replace('emkt_', DB_PREFIX, implode(file($file_name)));

        if (self::$db_family == 'myisam') {
            $buffer = str_ireplace('ENGINE=InnoDB', 'ENGINE=MyISAM', $buffer);
        }

        $pdo = new \PDO(DB_TYPE . ':host=' . DB_SERVER, DB_USERNAME, DB_PASSWORD, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"]);
        $mysql_version = $pdo->query('select version()')->fetchColumn();

        if (version_compare($mysql_version, '5.7.8') < 0) {
            header('Location: /controller/install/?route=error&mysql_version_false=true');
            exit;
        }

        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        Pdo::getExec($buffer);

        $password_admin_hash = Authorize::passwordHash(self::$password_admin);

        if (Valid::inPOST('login_admin') && Valid::inPOST('password_admin')) {
            Pdo::action("INSERT INTO " . TABLE_ADMINISTRATORS . "  SET login=?, password=?, permission=?, language=?, chatgpt_token=?", [self::$login_admin, $password_admin_hash, 'admin', self::$lng, json_encode([])]);
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [self::$lng]);
        }

        if (file_exists(ROOT . '/.htaccess')) {
            chmod(ROOT . '/.htaccess', 0644);
        }

        Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [self::$lng]);
    }

}
