<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	
		// Структура меню
		$level = array();
		$menu = array();
		$submenu = array();
	
		//LEVEL 0
		$level[0] = 'Раздел 1';
	
			$menu[0][0] = 'Меню 0';
				$submenu[0][0][0] = 'Подменю 0';
				$submenu[0][0][1] = 'Подменю 1';
	
			$menu[0][1] = 'Меню 1';
				$submenu[0][1][0] = 'Подменю 0';
				$submenu[0][1][1] = 'Подменю 1';
				$submenu[0][1][2] = 'Подменю 2';
				$submenu[0][1][3] = 'Подменю 3';
	
			$menu[0][2] = 'Меню 2';
	
		//LEVEL 1
		$level[1] = 'Раздел 2';
	
			$menu[1][0] = 'Меню 0';
				$submenu[1][0][0] = 'Подменю 0';
				$submenu[1][0][1] = 'Подменю 1';
	
			$menu[1][1] = 'Меню 1';
				$submenu[1][1][0] = 'Подменю 0';
				$submenu[1][1][1] = 'Подменю 1';

			$menu[1][2] = 'Меню 2';
				$submenu[1][2][0] = 'Подменю 0';
				$submenu[1][2][1] = 'Подменю 1';
	
			$menu[1][3] = 'Меню 3';

		//LEVEL 2
		$level[2] = 'Раздел 3';
	
			$menu[2][0] = 'Меню 0';
				$submenu[2][0][0] = 'Подменю 0';
				$submenu[2][0][1] = 'Подменю 1';
	
			$menu[2][1] = 'Меню 1';
				$submenu[2][1][0] = 'Подменю 0';
				$submenu[2][1][1] = 'Подменю 1';
	
			$menu[2][2] = 'Меню 2';

?>

<title><?php echo $lang['title_index'] ?></title>

</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding: 0 5px 0 5px;"><img src="/view/default/admin/images/img.png"></td>
		<td width="330" align="right" style="padding-right: 5px;" >
			<span style="color: #000000;"><b>SSL</b></span>
		</td>
	</tr>
</table>

<div id="administrationMenu" class="ThemeOfficeMainItem">
	
	<ul style="visibility: hidden">
	<?php	for ($i = 0; $i < count($level); $i++) { ?>
		<li>
			<span></span><span><?php echo $level[$i]; ?></span>
			<ul>
				<?php	for ($x = 0; $x < count($menu[$i]); $x++) { ?>
				<li>
					<span><img src="/view/default/admin/images/icons/" /></span><span><?php echo $menu[$i][$x]; ?></span>
					<ul>
						<?php	for ($y = 0; $y < count($submenu[$i][$x]); $y++) { ?>
						<li>
							<span><img src="/view/default/admin/images/icons/" /></span><a href="http://#"><?php echo $submenu[$i][$x][$y]; ?></a>
						</li>
						<?php } ?>
					</ul>
				</li>
					<?php } ?>
			</ul>
		</li>
	<?php } ?>
	</ul>
	
</div>

<script type="text/javascript"><!--
	cmDrawFromText('administrationMenu', 'hbr', cmThemeOffice, 'ThemeOffice');
//--></script>
