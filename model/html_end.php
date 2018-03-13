<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>
<?php //вывод только в админке
	if ($patch == 'admin'){ ?>
		
	} // конец вывода только в админке
	?>
<?php //вывод только в каталоге
	if ($patch == 'catalog'){ ?>

		<?php 
	} // конец вывода только в каталоге
	?>
		<link rel="stylesheet" type="text/css" href="/view/default/admin/style.css" media="screen" />
		<script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
		<script src="/ext/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>