<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>
<?php


 //вывод только в админке
	if ($patch == 'admin'){ ?>

	<?php } // конец вывода только в админке
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/admin/footer.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/view/default/admin/footer.php');
	?>
<?php //вывод только в каталоге
	if ($patch == 'catalog'){ ?>
				<link rel="stylesheet" type="text/css" href="/view/default/catalog/style.css" media="screen" />
				<script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
				<script type="text/javascript" src="/ext/bootstrap/js/bootstrap.min.js"></script>
		<?php 
	} // конец вывода только в каталоге
	?>
	
</body>
</html>