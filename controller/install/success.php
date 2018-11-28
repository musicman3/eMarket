<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

// Формируем данные для файла конфигурации
$http = 'http://' . $VALID->inSERVER('HTTP_HOST') . '/';
$ROOT = getenv('DOCUMENT_ROOT');
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
$lng = strtolower($VALID->inPOST('language'));
$tab_admin = $db_pref . 'administrators';
$tab_basic_settings = $db_pref . 'basic_settings';
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

// Подготавливаем данные для файла конфигурации
$config = '<?php' . "\n" .
        '  define(\'HTTP_SERVER\', \'' . $http . '\');' . "\n" .
        '  define(\'ROOT\', \'' . $ROOT . '\');' . "\n" .
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
        '  define(\'TABLE_BASIC_SETTINGS\', \'' . $tab_basic_settings . '\');' . "\n" .
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

// Если есть файл конфигурации, то ставим на него права 777
if (file_exists($ROOT . '/model/configure/configure.php') && !is_writeable($ROOT . '/model/configure/configure.php')) {
    chmod($ROOT . 'model/configure/configure.php', 0777);
}
// и записываем в него данные
if (file_exists($ROOT . '/model/configure/configure.php') && is_writeable($ROOT . '/model/configure/configure.php')) {
    $fp = fopen($ROOT . '/model/configure/configure.php', 'w');
    fputs($fp, $config);
    fclose($fp);
} else {

    // Если файла конфигурации нет, то переадресуем на страницу ошибки
    header('Location: /controller/install/error.php?file_configure_not_found=true');
}

// Подключаем CONFIGURE.PHP
require_once($ROOT . '/model/configure/configure.php');

// Подключаем соединение к БД
try {
$DB = new PDO(DB_TYPE . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

} catch (PDOException $error) {
    // Если ошибка соединения с БД, то переадресуем на страницу ошибки
    header('Location: /controller/install/error.php?server_db_error=true&error_message=' . $error->getMessage());
}

// Подключаем файл БД
if ($db_famyly == 'myisam') {
    $file_name = ROOT . '/model/databases/' . $db_famyly . '.sql';
}
if ($db_famyly == 'innodb') {
    $file_name = ROOT . '/model/databases/' . $db_famyly . '.sql';
}

// Если файла нет, то
if (!file_exists($file_name)) {

    // Если отсутствует файл БД, то переадресуем на страницу ошибки
    header('Location: /controller/install/error.php?file_not_found=true');
}

// Импортируем данные из файла БД
$buffer = str_replace('emkt_', DB_PREFIX, implode(file($file_name))); // Меняем префикс, если он другой
$DB->exec("set names utf8mb4");
$DB->exec($buffer);

// Сохраняем e-mail и пароль
$password_admin_hash = hash(HASH_METHOD, $password_admin); // Хэшируем пароль

if ($VALID->inPOST('login_admin') and $VALID->inPOST('password_admin')) {
    $DB->exec("INSERT INTO " . TABLE_ADMINISTRATORS . " (login, password, permission, language) VALUES ('$login_admin','$password_admin_hash','admin','$lng')");
}

$DB = null;

// СОЗДАЕМ .HTACCESS
$text = "#****** Copyright © 2018 eMarket ******#
#   GNU GENERAL PUBLIC LICENSE v.3.0   #
# https://github.com/musicman3/eMarket #
#**************************************#

Options -Indexes
php_flag ignore_repeated_errors off
php_flag ignore_repeated_source off
php_flag track_errors on
php_flag display_errors on
php_flag display_startup_errors on
php_flag log_errors on
php_flag mysql.trace_mode on
php_value error_reporting -1
php_value error_log " . ROOT . "/model/work/errors.log";


// Если файл существует, то ставим права 777
if (file_exists(ROOT . '/.htaccess') && !is_writeable(ROOT . '/.htaccess')) {
    chmod(ROOT . '/.htaccess', 0777);
}
// открываем файл
$fp = fopen(ROOT . '/.htaccess', "w");
// записываем в файл текст
fwrite($fp, $text);
fclose($fp);

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(getenv('DOCUMENT_ROOT') . '/model/end.php');
/* ------------------------------------------ */

?>
