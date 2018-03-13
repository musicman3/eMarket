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
	
			$menu[0][0] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 0</span>';
				$submenu[0][0][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[0][0][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';
	
			$menu[0][1] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 1</span>';
				$submenu[0][1][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[0][1][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';
				$submenu[0][1][2] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 2</a>';
				$submenu[0][1][3] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 3</a>';
	
			$menu[0][2] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 2</span>';
	
		//LEVEL 1
		$level[1] = 'Раздел 2';
	
			$menu[1][0] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 0</span>';
				$submenu[1][0][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[1][0][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';
	
			$menu[1][1] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 1</span>';
				$submenu[1][1][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[1][1][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';

			$menu[1][2] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 2</span>';
				$submenu[1][2][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[1][2][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';
	
			$menu[1][3] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 3</span>';

		//LEVEL 2
		$level[2] = 'Раздел 3';
	
			$menu[2][0] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 0</span>';
				$submenu[2][0][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[2][0][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';
	
			$menu[2][1] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 1</span>';
				$submenu[2][1][0] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 0</a>';
				$submenu[2][1][1] = '<span><img src="/view/default/admin/images/icons/" /></span><a href="http://www.mail.ru">Подменю 1</a>';
	
			$menu[2][2] = '<span><img src="/view/default/admin/images/icons/" /></span><span>Меню 2</span>';

?>

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
					<?php echo $menu[$i][$x]; ?>
					<ul>
						<?php	for ($y = 0; $y < count($submenu[$i][$x]); $y++) { ?>
						<li>
							<?php echo $submenu[$i][$x][$y]; ?>
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
