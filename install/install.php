<?php
/****** Copyright В© 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

<?php
	error_reporting(-1);

	//LOAD LANGUAGE
	require_once 'language/'.$_POST['language'].'.php';
		?>

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?php echo $lang['meta-language'] ?>" />
		<meta name="robots" content="noindex,nofollow" />
		<meta name="generator" content="HippoEDIT, Notepad++, Notepad++" />
		<meta name="classification" content="software" />
		<meta name="author" content="eMarket" />
		<meta name="owner" content="eMarket" />
		<meta name="copyright" content="CopyrightВ©2011 by eMarket Team. All right reserved." />

		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<title><?php echo $lang['title_success'] ?></title>
	</head>
	<body>

<?php

	$http = 'http://' . $_SERVER['HTTP_HOST'];

	if (isset($_SERVER['REQUEST_URI']) && (empty($_SERVER['REQUEST_URI']) === false)) {
		$http .= $_SERVER['REQUEST_URI'];
	} else {
		$http .= $_SERVER['SCRIPT_FILENAME'];
	}

	//IMPORT CONFIGURE
	$http = substr($http, 0, strpos($http, 'install'));
	$serv_db = $_POST['server_db'];
	$logindb = $_POST['login_db'];
	$passdb = $_POST['password_db'];
	$dbname = $_POST['database_name'];
	$dbpref = $_POST['database_prefix'];
	$dbport = $_POST['database_port'];
	$dbtype = $_POST['database_type'];
	$dbfamyl = $_POST['database_family'];
	$logadm = $_POST['login_admin'];
	$pasadm = $_POST['password_admin'];
	$lng = $_POST['language'];
	$tabadm = $dbpref.'administrators';
	$tab_cat = $dbpref.'categories';
	$tablist = $dbpref.'listing';
	$hashmet = $_POST['hash_method'];
	$crypt = $_POST['crypt_method'];

	$formhid = '<input type="hidden" name="language" value="'.$lng.'" />';

	//WRITE IN FILE CONFIGURE.PHP
	$datconf = '<?php' . "\n" .
	'  define(\'HTTP_SERVER\', \'' . $http . '\');' . "\n" .
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
	'?>';

	if (file_exists('../model/configure/configure.php') && !is_writeable('../model/configure/configure.php')) {
		@chmod('../model/configure/configure.php', 0777);
	}

	if (file_exists('../model/configure/configure.php') && is_writeable('../model/configure/configure.php')) {
		$fp = fopen('../model/configure/configure.php', 'w');
		fputs($fp, $datconf);
		fclose($fp);
	}else{

			echo '
			<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width: 100%; height: 100%">
				<tr align="center">
					<td align="center">
						<form style="display: inline;" action="index.php" method="post" accept-charset="utf-8">
							<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width:50%; position:absolute; top:100%; left:50%; margin:-25% 0 0 -25%;">
								<tr align="center">
									<td align="center">
										<h3>'.$lang['file_configure_not_found'].'</h3>
										'.$formhid.'
										<input class="button" type="submit" value="'.$lang["button_go_login"].'" />
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>';
		exit;
	}

	//REQUIRE CONFIGURE.PHP
	require_once('../model/configure/configure.php');

	$DB = new PDO(DB_TYPE.':host='.DB_SERVER.';dbname='.DB_NAME,DB_USERNAME,DB_PASSWORD);

	if (!$DB)
	{
			?>

			<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width: 100%; height: 100%">
				<tr align="center">
					<td align="center">
						<form action='index.php' method='post' accept-charset='utf-8' style='display: inline;'>
							<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width:50%; position:absolute; top:100%; left:50%; margin:-25% 0 0 -25%;">
								<tr align="center">
									<td align="center">
										<h3><?php echo $lang['server_db_error'] ?></h3>
										<?php echo $formhid ?>
										<input class="button" type="submit" name="button_go_login" value="<?php echo $lang['button_go_login'] ?>" />
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>

	<?php
		exit();
		}

	if ($dbfamyl == 'myisam'){
		$fname = "databases/".$dbfamyl.".sql";
	}
	if ($dbfamyl == 'innodb'){
		$fname = "databases/".$dbfamyl.".sql";
	}

			if (!file_exists($fname)) die ('
			<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width: 100%; height: 100%">
				<tr align="center">
					<td align="center">
						<form style="display: inline;" action="index.php" method="post" accept-charset="utf-8">
							<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width:50%; position:absolute; top:100%; left:50%; margin:-25% 0 0 -25%;">
								<tr align="center">
									<td align="center">
										<h3>'.$lang['file_not_found'].'</h3>
										'.$formhid.'
										<input class="button" type="submit" value="'.$lang["button_go_login"].'" />
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>');

$buffer = implode(file($fname));
$buffer = str_replace('emkt_',DB_PREFIX,$buffer); //REPLACE PREFIX

$DB->exec($buffer);
//END IMPORT DB

//SAVE E-MAIL AND PASSWORD
$pasadm = hash(HASH_METHOD, $pasadm);

	if(isset($_POST['login_admin']) and isset($_POST['password_admin'])){
		$DB->exec("INSERT INTO ".TABLE_ADMINISTRATORS." (login, password, permission, language) VALUES ('$logadm','$pasadm','admin','$lng')");
	}

$DB = null;

// СОЗДАЕМ .HTACCESS
$text = 
"#****** Copyright © 2018 eMarket ******#
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
php_value error_log ".$_SERVER['DOCUMENT_ROOT']."/model/work/errors.log";
		 

//Если файл существует, то ставим права 777
if (file_exists('../.htaccess') && !is_writeable('../.htaccess')) {
	@chmod('../.htaccess', 0777);
}
// открываем файл, если файл не существует, то делается попытка создать его
$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/.htaccess', "w");
		 
// записываем в файл текст
fwrite($fp, $text);
fclose($fp);

	?>

		<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width: 100%; height: 100%">
			<tr align="center">
				<td align="center">
					<form action='../controller/admin/verify/login.php' method='post' accept-charset='utf-8' style='display: inline;'>
						<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width:50%; position:absolute; top:100%; left:50%; margin:-25% 0 0 -25%;">
							<tr align="center">
								<td align="center">
									<h3><?php echo $lang['success'] ?></h3>
									<?php echo $formhid ?>
									<input class="button" type="submit" name="button_go_login" value="<?php echo $lang['button_go_login'] ?>" />
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>