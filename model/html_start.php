<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="<?php echo $lang['meta-language'] ?>" />
<meta name="robots" content="noindex,nofollow" />
<meta name="generator" content="HippoEDIT, Notepad++" />
<meta name="classification" content="software" />
<meta name="author" content="eMarket" />
<meta name="owner" content="eMarket" />
<meta name="copyright" content="Copyright©2018 by eMarket. All right reserved." />
<?php $title_prefix = basename(($_SERVER['REQUEST_URI']), '.php'); // автогенерация префикса title по названию файла. Пример: для index.php = index ?>
<title><?php echo $lang['title_'.$title_prefix] ?></title>
<link rel="stylesheet" type="text/css" href="/view/default/<?php echo $patch ?>/style.css" media="screen" />
<script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
<?php //вывод только в админке
	if ($patch == 'admin'){ ?>
		<script type="text/javascript" src="/view/default/admin/js/jscookmenu/JSCookMenu.js"></script>
		<script type="text/javascript" src="/view/default/admin/js/jscookmenu/ThemeOffice/theme.js"></script>
		<link rel="stylesheet" href="/view/default/admin/js/jscookmenu/ThemeOffice/theme.css" type="text/css">
		<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/view/default/admin/header.php');
	} // конец вывода только в админке
	?>